<?php
$bucketname = 'uploads/requests/';
?>


<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<!-- DataTables JS -->


<style>
.panel {
    box-shadow: 1px 2px 13px #ccc!important;
}
.panel:hover {
    box-shadow: 1px 2px 7px #f2f2f2!important;
}
.table-info thead th, .table-info thead tr {
    background: #1d89cf!important;
}
a { margin-right: 10px; }

  a i {
        margin-right: 10px;
        font-size: 16px;
        color: #007bff;
    }
    a:hover i {
        color: #0056b3;
    }
	input[type=file]::file-selector-button {
  margin-right: 20px;
  border: none;
  background: #1a7ab9;
  padding: 10px 20px;
  border-radius: 20px;
  color: #fff;
  cursor: pointer;
  transition: background .2s ease-in-out;
}

input[type=file]::file-selector-button:hover {
  background: #0d45a5;
}
input[type=file] {
    display: block;
    height: 49px!important;
    margin-bottom: 10px!important;
}
</style>

<style>
  
</style>
<?PHP $roleid = $this->session->userdata('role_id'); 
$da = array(6,67,59,2);  // Roles that can process & download
$va = array(6,7); 
$sa = array(4,2,59);    

$sf = $_SESSION['name'];
			 //&& substr($sf, 0, 2) === "25"
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Student</a></li>
        <li class="active"><a href="#"> Request Letter</a></li>
    </ul>

    <div class="page-header">           
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm">
                <i class="fa fa-dashboard page-header-icon text-danger"></i>&nbsp;&nbsp; Request List
            </h1>
        </div>

        <div class="row"><div class="col-sm-12">&nbsp;</div></div>

        <div class="row">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
					<div class="row">
					<div class="col-sm-11">
                        <span class="panel-title"><strong> Request List</strong></span>
						</div>
						
						<?php if (in_array($roleid, $da) || in_array($roleid, $va)
							 || ($roleid==4  && substr($sf, 0, 2) === "25")
						) { ?>
						<div class="col-sm-1">
						
						<a class="btn btn-primary form-control " id="btn_submit" type="submit" href="<?php echo site_url($this->router->class . '/bank_letter_request'); ?>">Add </a>
						
								
                    </div>
						<?php }?>
					       </div>	
						
						
						
                    </div>

                    <div class=" panel-body">  
                       <!-- Hidden Form -->


<form method="POST" id="pdfDownloadForm" action="<?= site_url('Letter/generate_package_pdf') ?>" target="_blank">

     <input type="hidden" name="stud_id" id="pdfStudId" value="<?= $request['stud_id'] ?>">
     <input type="hidden" name="admission_stream" id="pdfStream" value="<?= $request['admission_stream'] ?>">
     <input type="hidden" name="admission_session" id="pdfSession" value="<?= $request['admission_session'] ?>">
	 <input type="hidden" name="pdfrqrt" id="pdfrqrt" value="<?= $request['pdfrqrt'] ?>">
	 <input type="hidden" name="requestid" id="requestid" value="<?= $request['requestid'] ?>">
     <button type="submit" class="btn btn-light p-1 hidden" title="Download PDF">     	 
    </button>
	
</form>
                            <div align="center" id="stddata">
                                <table id="requestTable" class="table-info table table-bordered" style="width:100%!important">

									<thead>
									<tr>
									<th>Sn</th>
									<th>Admission Year<br><input type="text" class="form-control form-control-sm column-search" data-col="1" placeholder="Search Admission"></th>
									<th>Academic Year<br><input type="text" class="form-control form-control-sm column-search" data-col="2" placeholder="Search Year"></th>
									<th>Enrollment No<br><input type="text" class="form-control form-control-sm column-search" data-col="3" placeholder="Search Enrollment"></th>
									<th>Student Name<br><input type="text" class="form-control form-control-sm column-search" data-col="4" placeholder="Search Name"></th>
									<th>School Name<br><input type="text" class="form-control form-control-sm column-search" data-col="5" placeholder="Search School"></th>
									<th>Course Name<br><input type="text" class="form-control form-control-sm column-search" data-col="6" placeholder="Search Course"></th>
									<th>Stream Name<br><input type="text" class="form-control form-control-sm column-search" data-col="7" placeholder="Search Stream"></th>
									<th>State Code<br><input type="text" class="form-control form-control-sm column-search" data-col="8" placeholder="Search State"></th>
									<th>Request For<br><input type="text" class="form-control form-control-sm column-search" data-col="9" placeholder="Search Type"></th>
									<th>Request No<br><input type="text" class="form-control form-control-sm column-search" data-col="10" placeholder="Search Req No"></th>
									<th>Remark<br><input type="text" class="form-control form-control-sm column-search" data-col="11" placeholder="Search Remark"></th>
									<th>Requested Date<br><input type="text" class="form-control form-control-sm column-search" data-col="12" placeholder="Search Date"></th>
									<!--<th>Hostel<br><input type="text" class="form-control form-control-sm column-search" data-col="13" placeholder="Search Date"></th>-->
									<th>Last year Demand<br><input type="text" class="form-control form-control-sm column-search" data-col="14" placeholder="Search Date"></th>
									<th>Current Year<br><input type="text" class="form-control form-control-sm column-search" data-col="15" placeholder="current year"></th>
									<th>Hostel Opted?<br><input type="text" class="form-control form-control-sm column-search" data-col="16" placeholder="current year"></th>
									<th>Status<br><input type="text" class="form-control form-control-sm column-search" data-col="17" placeholder="Search Status"></th>
									<th>Action</th>
									</tr>
									</thead>

                                    <tbody id="itemContainer">
                                        <?php 
                                            $sn = 1;
                                            foreach($Studentrequest as $request): 
                                        ?>
                                        <tr>
                                            <td><?= $sn ?></td>
											<td><?= $request['admission_session'] ?></td>
                                            <td><?= $request['academic_year'] ?></td>                        
                                            <td><?= $request['enrollment_no'] ?></td>
											<td><?= $request['first_name'] ?></td>
											<td><?= $request['school_name'] ?></td>
											<td><?= $request['coursename'] ?></td>
											<td><?= $request['stream_name'] ?></td>
											<td><?= $request['state_code'] ?></td>
                                            <td><?= $request['rt'] ?></td>
											<td><?= $request['request_no'] ?></td>
                                            <td><?= $request['remark'] ?></td>
                                            <td><?= $request['created_on'] ?></td>
											
											
                                            <!--<td>
                                             <?= !empty($request['sf_id']) ? 'yes' : 'no'; ?>   
                                            </td>-->
											<td><?= !empty($request['total_fees_applicable']) ? $request['total_fees_applicable'] : $request['applicable_fee']; ?>
</td>
											<td><?= $request['current_year'] ?></td>
											<td>
                                             <?= ($request['is_hostel'] == 'Y') ? 'Yes' : 'No' ?>   
                                            </td>
											<td>
                                             <?= ($request['is_processed'] == 'N') ? 'Pending' : 'Done' ?>   
                                            </td>
											
											
                                            <?php /* if (in_array($roleid, $da)) { ?>
                                           <!-- <td>
<a href="javascript:void(0);" 
   class="open-process-modal" 
   data-request-id="<?= $request['id'] ?>"  data-folder-id="<?= $request['foldershortcode'] ?>" 
   title="Process">
   <i class="fa fa-magic"></i>
</a>

<?php if($request['is_processed'] == 'Y') {
	$bucketname1=$bucketname.$request['foldershortcode']."/";
	
	?>


<a href="<?= site_url() ?>Upload/get_document/<?php echo $request['processed_doc'] . '?b_name=' . $bucketname1;  ?>"  target="_blank" title="Download Document"> <i class="fa fa-download"></i> </a>
<?php }?>

</td>-->
											
											<?php } */ ?>
											
									
<td>
    <!-- VERIFY: Roles in $va AND is_verified == 'N' -->
    <?php /*if (in_array($roleid, $va) && $request['is_verified'] == 'N'): ?>
        <a href="javascript:void(0);" 
           class="verify-request" 
           data-request-id="<?= $request['id'] ?>" 
           title="Verify">
           <i class="fa fa-check-circle"></i>
        </a>
    <?php endif;*/ ?>

    <!-- PROCESS: Roles in $da AND is_verified == 'Y' AND is_processed == 'N' -->
    <?php if (in_array($roleid, $da)  && $request['is_processed'] == 'N'): ?>
        <a href="javascript:void(0);" 
           class="open-process-modal" 
           data-request-id="<?= $request['id'] ?>"  
           data-folder-id="<?= $request['foldershortcode'] ?>" 
           title="Process">
           <i class="fa fa-magic"></i>
        </a>
		
		<?php 
		
		
		if ($request['admission_session'] == '2025'): ?>
        <a href="javascript:void(0);"
   onclick="downloadPackagePdf('<?= $request['stud_id'] ?>', '<?= $request['admission_stream'] ?>', '<?= $request['admission_session'] ?>','<?= $request['request_type'] ?>','<?= $request['id'] ?>')"
   title="Preview">
   <i class="fa-regular fa-file-lines" ></i>
</a>
    <?php endif; ?>
		
    <?php endif; ?>

    <!-- DOWNLOAD: Roles in either $da or $va AND is_processed == 'Y' -->
    <?php if ($request['is_processed'] == 'Y'): 
        $bucketname1 = $bucketname . $request['foldershortcode'] . "/";
    ?>
        <a href="<?= site_url() ?>Upload/get_document/<?php echo $request['processed_doc'] . '?b_name=' . $bucketname1; ?>"  
           target="_blank" title="Download Document">
           <i class="fa fa-download"></i>
        </a>
    <?php endif; ?>
	
	
</td>
							
                                            
                                           
                                        </tr>
                                        <?php 
                                            $sn++; 
                                            endforeach; 
                                        ?>
                                    </tbody>
                                </table>

                                <!-- 🔽 PAGINATION LINKS -->
                                <div class="text-center">
                                    <?= $pagination_links ?>
                                </div>

                            
                        </div>
                    </div>
                </div>
            </div>    
        </div>          
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="processModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <form id="processForm" enctype="multipart/form-data" class="modal-content">
      <div class="modal-header bg-light">
	  
       <div class="row">
	  <div class="col-sm-10">
        <h5 class="modal-title"><strong>Upload Document<strong></h5>
		</div>
		<div class="col-sm-1">
       
		<button type="button" class="btn-close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
		
      </div>
      </div>
	  </div>
      <div class="modal-body">
	  <div class=" row d-flex justify-content-center">

    <div class="col-sm-12">
      <input type="file" name="process_doc" id="process_doc" class="form-control mb-3" required>
      <input type="hidden" name="request_id" id="modalRequestId">
      <input type="hidden" name="folder_id" id="modalfolderId">
    </div>
  </div>
</div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-primary">Upload</button>


        
      </div>
    </form>
  </div>
</div>


<!-- jQuery (Google CDN or choose from jQuery CDN, Cloudflare, etc.) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script>
let table = $('#requestTable').DataTable({
  dom: 'Bfrtip',
  paging: false, 
  orderCellsTop: true,
  fixedHeader: true
});

// Bind search inputs
$('.column-search').on('keyup', function () {
	
  let colIndex = $(this).data('col');
  table.column(colIndex).search(this.value).draw();
});



$(document).ready(function() {
  $('.open-process-modal').on('click', function() {
    var requestId = $(this).data('request-id');
	var folder = $(this).data('folder-id');
    $('#modalRequestId').val(requestId);
	$('#modalfolderId').val(folder);
    $('#processModal').modal('show');
  });
  
 // Clone the header row for filters
// Clone the header row for filters
// Clone the header row and add input fields
// Clone the header row and add a class



  // Handle form submission via AJAX
  $('#processForm').on('submit', function(e) {
    e.preventDefault();
    var formData = new FormData(this);

    $.ajax({
      url: '<?= base_url($this->router->class."/upload_process_doc") ?>',
      type: 'POST',
      data: formData,
      contentType: false,
      processData: false,
      success: function(response) {
        alert('Processed successfully!');
        $('#processModal').modal('hide');
       // location.reload();
      },
      error: function() {
        alert('Upload failed. Please try again.');
      }
    });
  });
});


$('.verify-request').on('click', function() {
    var requestId = $(this).data('request-id');
    if (confirm('Are you sure you want to verify this request?')) {
        $.ajax({
            url: '<?= base_url($this->router->class . "/verify_request") ?>',
            type: 'POST',
            data: { request_id: requestId },
            success: function(response) {
                alert('Request verified successfully!');
                location.reload();
            },
            error: function() {
                alert('Verification failed. Please try again.');
            }
        });
    }
});

</script>
<script>

function downloadPackagePdf(studId, stream, session,request_type,request_id) {	

  document.getElementById('pdfStudId').value = studId;
  document.getElementById('pdfStream').value = stream;
  document.getElementById('pdfSession').value = session;
  document.getElementById('pdfrqrt').value = request_type;
  document.getElementById('requestid').value = request_id;
  document.getElementById('pdfDownloadForm').submit();
  
}
</script>