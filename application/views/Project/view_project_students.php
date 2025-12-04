<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style>
.panel-heading {
    color: #8a6d3b;
    background-color: #fcf8e3;
    border-color: #faebcc;
}
</style>


<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
   //echo "<pre>";
   //echo $total_fees['fee_paid'];
 // print_r($student_details);
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
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;projects </h1>
            
            <div class="text-right" style="margin: 10px" >
                <a href="<?=base_url($currentModule)?>" class="btn btn-primary "><i class="fa fa-arrow-left"></i> Back</a>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading ">
                        <span class="panel-title">View Project Students </span>
						
						<span id="message" style="color:red;padding-left:200px;"></span>
                        <div class="holder"></div>
					</div>
                    <div class="panel-body">
                        <div>
                            <table class="table table-bordered" style="width:100%;max-width:100%;">
                                <tr>
                                    <th>Project Title:</th>
                                    <td><?= $project_details['project_title'] ?></td>
                                </tr>
                                <tr>
                                    <th>Faculty Code:</th>
                                    <td><?= $project_details['fac_name']."-".$project_details['faculty_id'] ?></td>
                                </tr>
								
								 <tr>
                                    <th>Domain:</th>
                                    <td><?= $project_details['domain'] ?></td>
                                </tr>
								
								<tr>
                                    <th>Industry Sponsored:</th>
                                    <td><?= $project_details['industry_sponsored'] ?></td>
                                </tr>
								
								<tr>
                                    <th>Programming Language/Technology Used:</th>
                                    <td><?= $project_details['programminglanguage'] ?></td>
                                </tr>
								
								<tr>
                                    <th>Bloom Level:</th>
                                    <td><?= $project_details['Bl_level'] ?></td>
                                </tr>
                                <tr>
                                    <th>Academic Year:</th>
                                    <td><?= $project_details['academic_year'] ?></td>
                                </tr>
                               
                            </table>
                        </div>

                        <div class="table-info">                            
                            <table class="table table-bordered" style="width:100%;max-width:100%;" >
                                <tr class="info" >
                                    <th>#</th>
                                    <th>Student Name</th>
                                    <th>Enrollment No New</th>
                                    <th>Enrollment No</th>
									<?php $role = $this->session->userdata('role_id');
    if (in_array((int)$role, [10, 20, 1])) { ?>
									
									<th>Action</th>
	<?php } ?>
                                </tr>
                              <?php
$i=1;
							  foreach ($project_students as $student):
?>
<tr>
    <td><?= $i ?></td>
    <td><?= $student['first_name'].' '.$student['middle_name'].' '.$student['last_name'] ?></td>
    <td><?= $student['enrollment_no_new'] ?></td>
    <td><?= $student['enrollment_no'] ?></td>
	<?php if (in_array((int)$role, [10, 20, 1])) { ?>
    <td>
        <form method="post" action="<?= base_url('Project/remove_student') ?>"
              onsubmit="return confirm('Remove this student from the project?');"
              style="display:inline-block;">

            <!-- CSRF (if enabled) -->
            <input type="hidden" name="<?= $csrf_name ?>" value="<?= $csrf_hash ?>">

            <!-- Required identifiers -->
            <input type="hidden" name="project_id"    value="<?= (int)$project_details['id'] ?>">
            <input type="hidden" name="student_id"    value="<?= (int)$student['stud_id'] ?>">
            <input type="hidden" name="academic_year" value="<?= html_escape($project_details['academic_year']) ?>">

            <button type="submit" class="btn btn-xs btn-danger" title="Remove">
                <i class="fa fa-times"></i> Remove
            </button>
        </form>
    </td>
	<?php } ?>
</tr>
<?php
$i++;
endforeach;
?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>    
        </div>
    </div>
</div>




