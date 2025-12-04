<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>

.enrollment-group input {
    width: 92%;
}
.enrollment-group .remove-enrollment {
    width: 8%;
}
.lt{margin-top: 20px;}
.table-danger, .table-info, .table-light, .table-primary, .table-success, .table-warning
Specificity: (0,1,0)
 {
    margin-bottom: 0px!important;
}
.hidetext{width: 82%; margin-top: 10px;float:left}
.bbn {
    width: 10%;
    margin-top: 10px;
    float: left;
    border: #aaaaaa solid 1px;
    padding: 5px;
}
.ttm {

    display: flex
    position: absolute;
    right: 7px;
    top: 61px;
}
.theme-default .bordered, .theme-default .panel, .theme-default .table, .theme-default hr {
    border-color: #e2e2e2;
}
</style>


<?php
$astrik='<sup class="redasterik" style="color:red">*</sup>';
$isEdit     = isset($mode) && $mode === 'edit';
$rec        = $isEdit && !empty($project) ? (object)$project : null;


$formAction = $isEdit ? site_url('Project/update/'.(int)$rec->id) : site_url('Project/add_project_detail');


$v = function ($key, $fallback = '') use ($rec) {
    if (function_exists('set_value')) {
        $sv = set_value($key);
        if ($sv !== '') return $sv; // posted value after validation fail
    }
    return $rec->$key ?? $fallback; // DB value (edit) or fallback
};

$faculty_arr = [];
if (!empty($faculty_list)) {
    foreach ($faculty_list as $f) {
        $faculty_arr[] = $f['emp_id'].', '.$f['fac_name'].', '.$f['department_name'];
    }
}


//print_r($rec  );



?>
<script>
toastr.options = { closeButton:true, progressBar:true, positionClass:'toast-top-right' };
</script>

<?php if ($m = $this->session->flashdata('message_project_success')): ?>
<script>
toastr.success(<?= json_encode($m) ?>, "Success");
</script>
<?php endif; ?>

<?php if ($m = $this->session->flashdata('message_project_error')): ?>
<style>#toast-container .toast-message{ white-space: pre-line; }</style>
<script>
toastr.error(<?= json_encode($m) ?>, "Error");
</script>
<?php endif; ?>


<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Project </a></li>
    </ul>
    <div class="page-header pb-2">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Project Details </h1><br/>
            <!-- <div class="col-xs-12 col-sm-8">
                <div class="row"> 
						<br/>				
					<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message_project_success'))){ echo $this->session->flashdata('message_project_success'); } ?></span>
					<span id="flash-message" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message_project_error'))){ echo $this->session->flashdata('message_project_error'); } ?></span>
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div> -->
        </div>
        <div class="row mt-2">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading ">
                        <!--<span class="panel-title">Add Project Details </span>-->
						   <h4><?= $isEdit ? 'Edit Project' : 'Add Project Detail Entry' ?></h4>
						<!--<span id="message" style="color:red;padding-left:200px;"></span>-->
                        <div class="holder"></div>
					</div>
                    <div class="panel-body">
                        <div class="table-info">                              
                          



<form method="POST" action="<?= $formAction ?>" autocomplete="off">
    <div class="row">
        <div class="col-md-3 mb-3">
            <label class="form-label">Academic Year<?=$astrik;?></label>
            <select name="academic_year" class="form-control form-control-sm" required>
                <option value="">Select</option>
              <?php
                                            $selected_year = $v('academic_year', defined('ACADEMIC_YEAR') ? ACADEMIC_YEAR : '');
                                            if (!empty($academic_year)) {
                                                foreach ($academic_year as $ay) {
                                                    $ayv = $ay['academic_year'];
                                                    $sel = ($ayv == $selected_year) ? 'selected' : '';
                                                    echo '<option value="'.$ayv.'" '.$sel.'>'.$ayv.'</option>';
                                                }
                                            }
                                            ?>
            </select>
        </div>
  <div class="col-md-3 mb-3">
    <label class="form-label">Department<?=$astrik;?></label>
    <select name="stream_id" class="form-control form-control-sm" required>
        <option value="">Select</option>
        <?php
        if (!empty($departments)) {
            $selected_department = $v('stream_id', '');
            foreach ($departments as $dept) {
                $deptId = $dept['stream_id'];
                $deptName = $dept['stream_name'];
                $sel = ($deptId == $selected_department) ? 'selected' : '';
                echo '<option value="'.$deptId.'" '.$sel.'>'.$deptName.'</option>';
            }
        }
        ?>
    </select>
</div>
        <div class="col-md-3 mb-3">
            <label class="form-label">Project Title<?=$astrik;?></label>
            <input type="text" name="project_title" class="form-control form-control-sm"
                   required pattern="^[a-zA-Z0-9\s&:-]+$"   value="<?= htmlspecialchars($v('project_title')) ?>"
                   title="Only letters, numbers, spaces, &, :, and - allowed.">
        </div>
  
    <!--<div class="col-md-3 mb-3">
        <label class="form-label">Enrollment Numbers</label>

        <div id="enrollment-container">
            <div class="enrollment-group d-flex align-items-center mt-5 mb-2">
                <input type="text" name="enrollment_no[]" class="form-control form-control-sm me-2"
                       placeholder="Enter 12-digit Enrollment No" pattern="^[0-9]{12}$"
                       title="Must be a 12-digit number" required>
            </div>
        </div>
		</div>
		    <div class="col-md-3 mt-5 mb-3" style="margin-top:30px"><button type="button" class="btn btn-primary btn-sm mt-2" id="add-enrollment">
            + Add Another Enrollment
        </button>
		<div class="form-text mt-2  text-muted fst-italic">
            <p style="margin-top:0px;font-size:11px;color:red">Add multiple enrollment numbers for the same project. Make sure all are filled and unique.</p>
        </div>
		</div>-->
		

          <div class="col-md-3 mb-3">
            <label class="form-label">Faculty Code <?=$astrik;?></label>
            <input type="text" name="faculty_code" class="form-control form-control-sm faculty_search"
                   required  value="<?= htmlspecialchars($isEdit ? ($facDisplay ?? $v('faculty_details')) : set_value('faculty_code')) ?>"
                  >
				   
				  
        </div>
		
    </div>
</div>








    <div class="row">
      
<div class="col-md-3 mb-3">
        <label class="form-label">Domain <?=$astrik;?></label>
        <input type="text" name="domain" class="form-control form-control-sm"
               required pattern="^[a-zA-Z0-9\s&:-]+$"
               title="Letters, numbers, spaces, &, :, and - only."  value="<?= htmlspecialchars($v('domain')) ?>">
    </div>
    

    <div class="col-md-3 mb-1">
        <label class="form-label">Industry Sponsored <?=$astrik;?></label>
        <input type="text" name="industry_sponsored" class="form-control form-control-sm"
               required pattern="^[a-zA-Z0-9\s&:-]+$" value="<?= htmlspecialchars($v('industry_sponsored')) ?>"
               title="Enter name of the industry or NA">
    </div>
 
    <div class="col-md-3 mb-3 mt-4">
    <label class="form-label">Programming Language <?=$astrik;?></label>
    <input type="text" name="programminglanguage" class="form-control form-control-sm"
           required pattern="^[a-zA-Z0-9\s,&:-]+$"
           title="Letters, numbers, spaces, comma, &, :, and - only."  value="<?= htmlspecialchars($v('programminglanguage')) ?>">
</div>


    <div class="col-md-3 mb-3 mt-4">
    <label class="form-label">Bloom Level <?=$astrik;?></label>
    <input type="text" name="Bl_level" class="form-control form-control-sm"
           required pattern="^[a-zA-Z0-9\s]+$"  value="<?= htmlspecialchars($v('Bl_level')) ?>"
           title="Only letters, numbers, and spaces allowed.">
</div>

        <!--<div class="col-md-3 mb-4 mt-4">
            <label class="form-label">Project Day</label>
            <select name="project_day" class="form-control form-control-sm" required>
                <option value="">Select</option>
                <option value="1">Monday</option>
                <option value="2">Tuesday</option>
                <option value="3">Wednesday</option>
                <option value="4">Thursday</option>
                <option value="5">Friday</option>
                <option value="6">Saturday</option>
                <option value="7">Sunday</option>
            </select>
        </div>-->
    </div>
</br>
    <div class="row">
        <div class="col-md-6 mt-2 mb-4">
            <button type="submit" class="btn btn-primary btn-sm">
                                            <?= $isEdit ? 'Update Project' : 'Add Project' ?>
                                        </button>
			
			<button type="button" class="btn btn-primary btn-sm" onclick="window.location.href='<?= base_url('Project') ?>'">Back</button>

        </div>
    </div>
	<br>
	<div class="col-md-12">
	<b>NOTE:</b>
        <ul> <li> Type Faculty Name or Code in Faculty Code input</li>
                                    <li> If the project is industry-sponsored, enter the name of the industry. Otherwise, write <strong>NA</strong>.</li>
                                    <li>Bloom level should be in format L1,L2,L3,L4,L5,L6.</li>
									<li>Domain, Industry Sponsored, and Programming Language fields will accept only: alphabets (A-Z, a-z), numbers (0-9), spaces, comma (,), ampersand (&), colon (:), and hyphen (-).</li>



                                </ul>
                                
                                
                            </div>
</form>

  </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>

<div class="modal fade" id="errorModal" tabindex="-1" role="dialog" aria-labelledby="errorModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="errorModalLabel">Error Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <ul id="errorList"></ul>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<?php if ($this->session->flashdata('message_project_success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> <?= $this->session->flashdata('message_project_success'); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; ?>

            <?php if ($this->session->flashdata('message_project_error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Warning!</strong> <?= nl2br($this->session->flashdata('message_project_error')); ?>
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            <?php endif; 
$faculty_arr = array();
foreach ($faculty_list as $value) {
	$faculty_arr[] = $value['emp_id'].", ".$value['fac_name'].", ".$value['department_name'];
} ?>
<script>
$(document).ready(function(){
    var tempArray = <?php echo json_encode($faculty_arr); ?>;
	 var dataSrc = tempArray;
	 $(".faculty_search").autocomplete({
        source:dataSrc
    });
	
});
</script>

<script>
    $(document).ready(function () {
        var errorMessage = "<?= addslashes(nl2br($this->session->flashdata('message_project_model_error'))); ?>";
        
        if (errorMessage) {
            var errorList = errorMessage.split("<br>").map(error => `<li>${error}</li>`).join("");
            $("#errorList").html(errorList);
            $("#errorModal").modal("show"); // Show the modal
        }
    });
</script>


<script>
document.addEventListener('DOMContentLoaded', function () {
    const container = document.getElementById('enrollment-container');
    const addBtn = document.getElementById('add-enrollment');
    const form = document.querySelector('form');

    // Restrict input to digits and max 12 digits
    container.addEventListener('input', function (e) {
        if (e.target.name === "enrollment_no[]") {
            e.target.value = e.target.value.replace(/\D/g, '').slice(0, 12);
        }
    });

    addBtn.addEventListener('click', () => {
        const inputs = container.querySelectorAll('input[name="enrollment_no[]"]');
        for (let input of inputs) {
            if (input.value.trim() === "") {
                input.focus();
                alert("Please fill all existing enrollment number fields before adding a new one.");
                return;
            }
        }

        const group = document.createElement('div');
        group.className = ' d-flex  ttm align-items-center mb-2 enrollment-group';

        group.innerHTML = `
            <div classname="ttm"><input type="text" name="enrollment_no[]" class="form-control hidetext me-2"
                   placeholder="Enter 12-digit Enrollment No" pattern="^[0-9]{12}$"
                   title="Must be a 12-digit number" required><button type="button" class="btn btn-sm btn-outline-danger bbn remove-enrollment">X</button></div>`;

        container.appendChild(group);
    });

    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-enrollment')) {
            e.target.closest('.enrollment-group').remove();
        }
    });

    form.addEventListener('submit', function (e) {
        const inputs = document.querySelectorAll('input[name="enrollment_no[]"]');
        const values = Array.from(inputs).map(input => input.value.trim());
        const duplicates = values.filter((val, idx) => values.indexOf(val) !== idx);

        if (duplicates.length > 0) {
            e.preventDefault();
            alert("Duplicate enrollment number(s): " + [...new Set(duplicates)].join(", "));
        }

        for (let input of inputs) {
            if (input.value.length !== 12) {
                e.preventDefault();
                alert("Each enrollment number must be exactly 12 digits.");
                input.focus();
                return;
            }
        }
    });
});
</script>
