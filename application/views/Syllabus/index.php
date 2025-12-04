
<style>table th, table td {
    vertical-align: middle !important;
}
.bg-info {
       
    }
    .font-weight-bold {
        font-weight: bold;
    }
</style>
<style>
    .label-text {
        font-weight: bold;
        color: #333;
    }
    .value-text {
        font-weight: normal;
        color: #000;
        margin-right: 10px;
    }
</style>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Syllabus</a></li>
        <!--<li class="active"><a href="<?=base_url($currentModule)?>">Master </a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp; Syllabus Topics and Subtopics</h1><span id="err_msg" style="color:red;"></span>
			<div class="pull-right col-xs-4 col-sm-auto"> 
				
	</div>

			<span id="flash-messages" style="color:Green;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>

        </div>

        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                   <span class="panel-title">
    <span class="label-text">Subject Code:</span> <span class="value-text"><?= $subject['subject_code']; ?></span>
    <span class="label-text">Subject Name:</span> <span class="value-text"><?= $subject['subject_name']; ?> (<?= $subject['subject_component'] ?>)</span>
    <span class="label-text">Semester:</span> <span class="value-text"><?= $subject['semester']; ?></span>
</span><button class="btn btn-info" data-toggle="modal" data-target="#importModal" style="float:right">
				<i class="fa fa-upload"></i> Import from Excel
			</button>
			<a href="<?= base_url('SyllabusController/download_pdf/'.$subject_id.'/'.$campus_id) ?>" class="btn btn-primary" target="_blank">
    Download PDF
</a>
<a href="<?= base_url('SyllabusController/deletesubjectsyllabus/'.$subject_id.'/'.$campus_id) ?>" class="btn btn-danger" onclick="return confirm('Delete this?')">
    Delete complete subject syllabus
</a>
                </div>
				
                <div id="show_list" class="panel-body"  >
                    <div class="table-info">    

       <table class="table table-bordered table-striped">
    <thead>
        <tr>
            <th>Sr. No.</th>
            <th>Topic</th>
            <th>Order No.</th>
            <th>Course Outcome</th>
            <th>Hours</th>
            <th>Minutes</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        <?php $sr = 1;  ?>
        <?php foreach ($topics as $topic): ?>
            <!-- Topic Row -->
            <tr class="bg-info text-black font-weight-bold" style="color:black!important;">
                <td><?= $topic['topic_order'] ?></td>
                <td><?= $topic['topic_title'] ?></td>
                <td colspan="0"><?= $topic['topic_order'] ?></td>
				<td><?= $topic['tcos'] ?></td>
				<td><?= $topic['thours'] ?></td>
				<td><?= $topic['tminutes'] ?></td>
            </tr>

            <?php if (!empty($topic['subtopics'])): ?>
                <?php foreach ($topic['subtopics'] as $sub): ?>
                    <tr>
                        <td><?= $sub['srno'] ?></td>
                        <td><?= $sub['subtopic_title'] ?></td>
                        <td><?= $sub['subtopic_order'] ?></td>
                        <td><?= $sub['cos'] ?></td>
                        <td><?= $sub['shours'] ?></td>
                        <td><?= $sub['sminutes'] ?></td>
                        <td>
                            <a href="<?= base_url('SyllabusController/edit_subtopic/' . $sub['subtopic_id'].'/'. $subject_id.'/'. $campus_id.'/'. $subject_details) ?>" class="btn btn-xs btn-warning">Edit</a>
                            <a href="<?= site_url('SyllabusController/delete_subtopic/' . $sub['subtopic_id'].'/'. $subject_id.'/'. $campus_id) ?>" class="btn btn-xs btn-danger" onclick="return confirm('Delete this?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        <?php $sr++; endforeach; ?>
    </tbody>
</table>

 </div>
                </div>
            </div>
			
            </div>    
        </div>
    </div>
</div>
<!-- Excel Import Modal -->
<div class="modal fade" id="importModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <form method="post" action="<?= base_url('SyllabusController/import_excel') ?>" enctype="multipart/form-data" onsubmit="return validateExcel();">
	<input type="hidden" name="subject_id" value="<?= $subject_id ?>">
	<input type="hidden" name="campus_id" value="<?= $campus_id ?>">
      <div class="modal-content">
        <div class="modal-header bg-info">
          <h4 class="modal-title text-white">Import Topics & Subtopics from Excel</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <div class="modal-body">
		<h4> Steps for Uploading Course Syllabus</h4>
    <ul>
        <li>
            <strong>Download the Sample Format</strong><br>
            Click on the <span class="highlight">“Download Sample”</span> button to get the Excel template.
            Only this format should be used.
        </li>
        <li>
            <strong>Set the First Column(A) as Text and Enter Serial Numbers</strong><br>
            Format the first column (Sr. No.) as <span class="highlight">Text</span> in Excel.<br>            
        </li>
        <li>
            <strong>Enter the Proper Topic Order</strong><br>
            Use the C column (Order No.) to define the topic structure:<br>
            <ul>
                <li>Main Topic: <span class="highlight">1, 2, 3, ...</span></li>
                <li>Subtopic: <span class="highlight">1.1, 1.2, 1.3, ...</span></li>
            </ul>
        </li>
        <li>
            <strong>Mark Main Topics in the Last Column</strong><br>
            In the last column(G), enter <span class="highlight">1</span> for main topics only.<br>
            0 for subtopics.
        </li>
    </ul>
          <p><strong>Note:</strong> Excel must follow this format:</p>
          <a href="<?= base_url('uploads/sample_syllabus_format.xlsx') ?>" class="btn btn-sm btn-success mb-2">
            <i class="fa fa-download"></i> Download Format
          </a>

          <div class="form-group">
            <label>Select Excel File (.xls or .xlsx)</label>
            <input type="file" name="excel_file" id="excel_file" class="form-control" accept=".xls,.xlsx" required>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Import</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
function validateExcel() {
  const fileInput = document.getElementById('excel_file');
  const filePath = fileInput.value;
  const allowedExtensions = /(\.xls|\.xlsx)$/i;

  if (!allowedExtensions.exec(filePath)) {
    alert('Please upload a valid Excel file (.xls or .xlsx).');
    fileInput.value = '';
    return false;
  }
  return true;
}
</script>
