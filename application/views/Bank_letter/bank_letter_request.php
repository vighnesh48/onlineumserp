 
<style>
.panel{padding:20px;}.alert {
    background: #bed3f3;
    border-color: #3e76db;
    color: #000000;
    background-size: 20px 20px;
}
</style>
<?PHP $roleid = $this->session->userdata('role_id'); 
$da = array(67,2,8,7,6,59);  
 
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Request</a></li>
        <li class="active"><a href="#">Bank letter Request Form</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Bank letter Request Form</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                   
                </div>
            </div>
        </div>
		<br>
	
        <div class="row">
            <div class="col-md-12">
			<br>
				<?php if ($this->session->flashdata('error')): ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert" style="width:50%;">
					<?php echo $this->session->flashdata('error'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				<?php endif; ?>

				<?php if ($this->session->flashdata('success')): ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert" style="width:50%;">
					<?php echo $this->session->flashdata('success'); ?>
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
					</div>
				<?php endif; ?>
		
		
                <div class="panel">
      
                <div class="form-group" >
                <br>     
                          
				<form action="<?php echo site_url($this->router->class . '/save_request'); ?>" method="post" onsubmit="return confirmSubmission();" enctype="multipart/form-data">	 
					 
					<div class="row  py-5 px-5">
						<div class="col-md-3">
							<label for="studentName" class="form-label">Enrollment Number<span style="color:red">*</span></label>
							<input type="text" class="form-control" name="enrollmentNumber" id="enrollmentNumber" placeholder="Enter student enrollment" value="<?php echo $studentData['enrollment_no']; ?>" <?php
$roleid = (int)$roleid;

							if (!in_array($roleid, $da, true)) 
							{ ?>readonly
						
    
<?php } ?>>




						 </div>
						 <input type="hidden" class="form-control" name="student_id" id="student_id"  value="<?php echo $studentData['stud_id']; ?>">
						 <div class="col-md-3">
							<label for="studentName" class="form-label">Student Name<span style="color:red">*</span></label>
						   <input type="text" class="form-control" name="studentName" id="studentName" placeholder="Enter student name" value="<?php echo $studentData['first_name']; ?>" 
						    <?php if (!in_array($roleid, $da, true)) { ?>
    readonly
<?php } ?>
						   
						   >
						 </div>
						 
						 <div class="col-md-3 hidden">
							<label for="state_code" class="form-label">State Code<span style="color:red">*</span></label>
						   <input type="text" class="form-control" id="state_code" name="state_code" value="<?php echo $studentData['state_code']; ?>" readonly>
						 </div>
						 
						 <div class="col-md-3">
							<label for="current_academic_year" class="form-label">Current Academic Year<span style="color:red">*</span></label>
							<select name="current_academic_year" id="current_academic_year" class="form-control" required readonly>
							  <option value=""> Academic Year</option>
							  <option value="<?php echo $studentData['academic_year']; ?>" selected ><?php echo $studentData['academic_year']; ?></option>
							  </select>
						 </div>
						 
						<div class="col-md-3">
							<label for="current_academic_year" class="form-label">Select Request Type<span style="color:red">*</span></label>
							<select name="request_type" id="request_type" required class="form-control"  >
								<option value="" >--Select Request Type--</option>
								<?php foreach($type as $row){ ?>
									<option value="<?= $row['name']."-".$row['short_code']."-".$row['id'] ?>"><?= $row['name'] ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<br>
					 
					
					<br>
 
					<div class="row ">
						
						<div class="col-md-6">
							<label for="studentName" class="form-label">Reason<span style="color:red">*</span></label>
							<textarea class="form-control" id="remark" name="remark"  required></textarea>
						</div>
						<div class="col-md-3">
    <label class="form-label">Want to opt hostel?<span style="color:red">*</span></label><br>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="is_hostel" id="hostelYes" value="Y" required>
        <label class="form-check-label" for="hostelYes">Yes</label>
    </div>
    <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="is_hostel" id="hostelNo" value="N">
        <label class="form-check-label" for="hostelNo">No</label>
    </div>
</div>

					</div>
					<br>
					 
				   <center>
					 <div class="col-md-12" style="margin-top:20px!important"> 
						<input type="submit" id="submitButton"  class="btn btn-primary" value="Submit" >
						<a href="<?= base_url('Letter/student_bank_letter_request_list') ?>" class="btn btn-primary">
						<i class="fa fa-arrow-left"></i> Back
						</a>

					 </div> 
					</center>
					 
				</form>
				<div class="clearfix my-5"></div>
				<div class=" col-sm-3 my-5 alert alert-primary" role="alert">
<span style="font-size: 18px; color: #ff0000; font-weight: 600;">&#9888;</span><span style="font-size:14px"> Kindly submit scanned request letter on the email<br>
<strong>Email Id:student.support@sandipuniversity.edu.in</strong><br>
<strong>Format:</strong>
<strong>Subject:</strong> (PRN) to (Name) Request for Loan Letter.</span>
</div>
                    
  
                         
                </div>

            </div>    
        </div>
    </div>
</div>

<!-- <script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>-->
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> 


<script>
 
  $('#enrollmentNumber').on('input blur change', function () {
	 
        let enroll = $(this).val();
		
        if ((enroll.length === 9 && /^[A-Za-z0-9]+$/.test(enroll)) || enroll.length === 12) {
            // Call your controller with AJAX
            $.ajax({
                url: "<?php echo site_url($this->router->class . '/get_student_details')?>",
                method: 'POST',
                data: { enrollment_no: enroll },
				dataType: 'json',
                success: function(response) {
					console.log(response);
					//document.getElementById("current_academic_year").value = response.admission_session;
					//$("#current_academic_year").val(response.admission_session);
					document.getElementById("studentName").value = response.first_name;
					document.getElementById("state_code").value = response.state_code;
					document.getElementById("student_id").value = response.stud_id;
					
				const academicYear = response.admission_session; // Replace with dynamic value
				const selectEl = document.getElementById('current_academic_year');
				if (selectEl) {
				// Create a new option if not already present
				let optionExists = [...selectEl.options].some(opt => opt.value === academicYear);
				if (!optionExists) {
				const option = new Option(academicYear, academicYear, true, true); // selected = true
				selectEl.add(option);
				} else {
				selectEl.value = academicYear; // just select it if it already exists
				}
				}
                },
                error: function(xhr, status, error) {
                    console.error('AJAX Error:', error);
                }
            });
        }
    });

</script>
<script>
function confirmSubmission() {
  return confirm("Are you sure you want to submit this request?");
}
</script>