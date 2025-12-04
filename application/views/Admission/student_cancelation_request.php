 
<style>
.form-group {
    padding: 10px;
}
</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Admission</a></li>
        <li class="active"><a href="#">Student Request Form</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Request Form</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                   
                </div>
            </div>
        </div>
		<br>
	
        <div class="row">
            <div class="col-md-12 ">
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
                          
				<form action="<?php echo site_url('Ums_admission/save_student_academic_request')?>" method="post" enctype="multipart/form-data">	 
					 
					<div class="row ">
						<div class="col-md-3">
							<label for="studentName" class="form-label">Enrollment Number<span style="color:red">*</span></label>
							<input type="text" class="form-control" name="enrollmentNumber" id="enrollmentNumber" placeholder="Enter student enrollment" value="<?php echo $_SESSION['name']; ?>" readonly>
						 </div>
						 
						 <div class="col-md-3">
							<label for="studentName" class="form-label">Student Name<span style="color:red">*</span></label>
						   <input type="text" class="form-control" id="studentName" placeholder="Enter student name" value="<?php echo $studentData['first_name']; ?>" readonly>
						 </div>
						 
						 <div class="col-md-3">
							<label for="current_academic_year" class="form-label">Current Academic Year<span style="color:red">*</span></label>
							<select name="current_academic_year" id="current_academic_year" class="form-control" required>
							  <option value=""> Academic Year</option>
							  <option value="<?php echo $studentData['academic_year']; ?>" selected ><?php echo $studentData['academic_year']; ?></option>
							  </select>
						 </div>
						 
						<div class="col-md-3">
							<label for="current_academic_year" class="form-label">Select Request Type<span style="color:red">*</span></label>
							<select name="request_type" id="request_type" class="form-control" onchange="checkEligibility(this)" required>
								<option selected disabled>--Select Request Type--</option>
								<!--<option value="1">Hostel</option>-->
								<!-- <option value="2">Transport</option>-->
								<!--<option value="3">Uniform</option>-->
								<!--<option value="4">Excess Fees</option>-->
								<option value="5">Cancel Admission</option>
								<!--<option value="6">Hostel Deposit Money</option>-->
							</select>
						</div>
					</div>
					<br>
					 
					<div class="row">
						<div class="col-md-3">
							<label for="studentName" class="form-label">Account Number<span style="color:red">*</span></label>
							<input type="text" class="form-control" name="account_number" id="account_number" placeholder="Enter Bank Account Number" required inputmode="numeric" pattern="\d*" maxlength="18" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
						</div>
						
						<div class="col-md-3">
							<label for="studentName" class="form-label">Account Holder Name<span style="color:red">*</span></label>
							<input type="text" class="form-control alphaOnly" id="account_holder_name" name="account_holder_name" placeholder="Enter Account Holder Name" required  oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')">
						</div>
						
						
						<!-- <div class="col-md-3">
							<label for="studentName" class="form-label">Account Number<span style="color:red">*</span></label>
							<input type="text" class="form-control" name="account_number" id="account_number" placeholder="Enter Bank Account Number" required>
						</div>-->
						<div class="col-md-3">
							<label for="ifsc_code" class="form-label">IFSC Code<span style="color:red">*</span></label>
							 <input type="text" class="form-control" id="ifsc_code" name="ifsc_code" placeholder="Enter IFSC Code" required oninput="this.value = this.value.replace(/[^a-zA-Z0-9]/g, '')" maxlength="11">
						</div>
						
						<div class="col-md-3">
							<label for="current_academic_year" class="form-label">Bank Name<span style="color:red">*</span></label>
							<select name="bank_name" id="bank_name" class="form-control" required>
								<option value="" selected>--Select Bank--</option>
								<?php foreach($bankMasterData as $bankData){ ?>
									<option value="<?= $bankData['bank_id'] ?>"><?= strtoupper($bankData['bank_name']) ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
					<br>
 
					<div class="row ">
						
						<div class="col-md-3">
							<label for="studentName" class="form-label">Upload Cancel cheque<span style="color:red">*</span></label>
							<input type="file" class="form-control" name="cancel_cheque" accept=".jpg, .jpeg, .png, .pdf" required>
						</div>
						
						<div class="col-md-6">
							<label for="studentName" class="form-label">Reason<span style="color:red">*</span></label>
							<input type="text" class="form-control" id="remark" name="remark" placeholder="Enter Reason" required>
						</div>
					</div>
					<br>
					 
				   <center>
					 <div class="col-md-12" style="margin-top:20px!important"> 
						<input type="submit" id="submitButton" disabled class="btn btn-primary" value="Submit" > 							 
					 </div> 
					</center>
					 
				</form>
                         
                         
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
 
function checkEligibility(param) {
	
    var selectType = param.value; // Get selected value
    var currentAcademicyear = "<?php  echo $studentData['academic_year']; ?>"
	var submitButton = document.getElementById("submitButton"); 
	
    if (selectType == 1 || selectType == 2 || selectType == 3 || selectType == 6) {
		
		$.ajax({
			url: "<?php echo site_url('Ums_admission/check_student_request_eligibility')?>",
			type: "POST",  
			data:{ 
					request_type: selectType, 
					curr_academic_year: currentAcademicyear 
				},
			dataType: "json", // Expecting JSON response
			success: function(response) {
			 
				if (response.status == 1 && response.data) {
					
					if (selectType == response.data.sffm_id || selectType == 6) {
						submitButton.removeAttribute("disabled");
					}
					if(response.data.productinfo == 'Uniform'){
						submitButton.removeAttribute("disabled");
					}
					
				} else {
					submitButton.setAttribute("disabled", true); // Disable button
					alert("You are not eligible for this selection");
				} 
			},
			error: function(xhr, status, error) {
				console.error("Error:", error);
			}
		});
	
	}else{
		submitButton.removeAttribute("disabled");
	}
	
}



    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.alphaOnly').forEach(function (input) {
            input.addEventListener('input', function () {
                this.value = this.value.replace(/[^a-zA-Z\s]/g, '');
            });
        });
    });
	 

</script>