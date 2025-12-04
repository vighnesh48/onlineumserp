
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<script>    
$(document).ready(function()
{
	$('#dddate').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
});
$('.numbersOnly').keyup(function () {
if (this.value != this.value.replace(/[^0-9\.]/g, '')) {
   this.value = this.value.replace(/[^0-9\.]/g, '');
}
});
</script>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">Examination</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Examination Form</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
		  <div class="row ">
			<form id="form" name="form" action="<?php echo base_url($currentModule . '/add_exam_form') ?>" method="POST">    

			<div class="col-sm-12">
				<div class="panel">
                    
                    <div class="panel-body">
					<div class="col-sm-12">
						<div class="panel">
						<div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">Personal Details</span>
						</div>
					<form name="exam_form" method="POST" action="<?php echo base_url($currentModule . '/add_exam_form') ?>">
                        
						<table class="table table-bordered">
    					<tr>
    					  <th width="12%">PRN No :</th>
						  <td width="38%"><?php echo $emp[0]['enrollment_no'] ?></td>
						  <th width="12%">Exam Name :</th>
						  <td width="38%" ><?php echo $exam[0]['exam_month'] ?>-<?php echo $exam[0]['exam_year'] ?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name :</th>
						  <td><?php echo $emp[0]['last_name'] ?> <?php echo $emp[0]['first_name'] ?> <?php echo $emp[0]['middle_name'] ?></td>
						   <th width="">DOB:</th>
						   <td><?php echo $emp[0]['dob'] ?> </td>
						</tr>
						<tr>
    					  <th scope="col">Course Name :</th>
						  <td><?php echo $emp[0]['stream_name'] ?></td>
						   <th width="">School :</th>
						   <td><?php echo $emp[0]['school_code'] ?>-<?php echo $emp[0]['school_name'] ?></td>
    					</tr>

						</table>
						</div>
						</div>
						
						<div class="col-sm-12">
							<div class="panel">
						<div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">Subject appearing</span>
						</div>
							<table class="table table-bordered">
							<thead>
								<tr>
									<th>Sr.No</th>
									<th>Subject Code</th>
									<th>Subject Name</th>
									<th>Semester</th>
									
								</tr>
							</thead>
							<tbody>
							<input type="hidden" name="exam_details" value="<?php echo $exam[0]['exam_id'] ?>~<?php echo $exam[0]['exam_month'] ?>~<?php echo $exam[0]['exam_year'] ?>~<?php echo $exam[0]['exam_type'] ?>">
							<input type="hidden" name="stream_id" value="<?php echo $emp[0]['admission_stream'] ?>">
							<input type="hidden" name="semester" value="<?php echo $emp[0]['admission_semester'] ?>">
							<input type="hidden" name="student_id" value="<?php echo $emp[0]['stud_id'] ?>">
							<input type="hidden" name="enrollment_no" value="<?php echo $emp[0]['enrollment_no'] ?>">
							<input type="hidden" name="school_code" value="<?php echo $emp[0]['school_code'] ?>">
							<input type="hidden" name="course_id" value="<?php echo $emp[0]['course_id'] ?>">
								<?php
								$i = 1;

								if (!empty($sublist))
									{
									foreach($sublist as $sub)
										{
								?>
								<tr>
									
									<td><?php echo $i; ?> &nbsp; &nbsp;<input type="hidden" name="sub[]" value="<?php echo $sub['sub_id'] ?>~<?php echo $sub['subject_code'] ?>"></td>
									<td><?php echo $sub['subject_code'] ?></td>
									<td><?php echo $sub['subject_name'] ?></td>
									<td><?php echo $sub['semester'] ?></td>
									
									
								</tr>
								<?php
										$i++;
										}
									}
								  else
									{
									echo "<tr><td colspan=4 style='color:red'>The Subjects are not allocated. Please contact to school Dean.</td></tr>";
									}

								?>
								</tbody>
							</table>
							</div></div>
							<div class="col-sm-12">
							<div class="panel">
							<div class="panel-heading">
							<?php
							if($emp[0]['course_id']==2 ||$emp[0]['course_id']==8 ||$emp[0]['course_id']==10 ||$emp[0]['course_id']==12 ||$emp[0]['course_id']==5 ||$emp[0]['course_id']==19 )
							{
									$dpay=2500;
							}
							else if($emp[0]['course_id']==13 ||$emp[0]['course_id']==6 ||$emp[0]['course_id']==7 ||$emp[0]['course_id']==4 ||$emp[0]['course_id']==11 ||$emp[0]['course_id']==9 ||$emp[0]['course_id']==14 )
							{
								$dpay=2000;
							}
							else{
								$dpay=3000;
							}

							?>
							<input type="hidden" name="applicable_fee" id="applicable_fee" value="<?php echo $dpay; ?>">
								<span class="panel-title" style="color:#FFF">Fee Details <div class="pull-right">Total Fees to pay: <?php echo $dpay;?></div></span>
							</div>
							
							<div class="clearfix">&nbsp;</div>
							<?php
							$i = 1;

							if (!empty($fee))
								{
							?>
							<div class="row">
								<div class="col-sm-12">
								<label class="col-sm-2">Payment Type:</label>
								<div class="col-sm-4">
									<?php echo $fee[0]['fees_paid_type'] ?>
								</div>
								<label class="col-sm-2">Recept No:</label>
								<div class="col-sm-4">
									<?php echo $fee[0]['receipt_no'] ?>
								</div>
																
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="row">
								<div class="col-sm-12">
								<label class="col-sm-2">Date:</label>
								<div class="col-sm-4">
									<?php
										if ($fee[0]['fees_date'] != '' && $fee[0]['fees_date'] != '0000-00-00')
											{
											echo date('d/m/Y', strtotime($fee[0]['fees_date']));
											}

									?>
								</div>
								<label class="col-sm-2">Amount:</label>
								<div class="col-sm-4">
									<?php echo $fee[0]['amount'] ?>
								</div>								
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
							<div class="row">
								<div class="col-sm-12">
								<label class="col-sm-2">Bank Name:</label>
								<div class="col-sm-4">
									<?php echo $fee[0]['bank_name'] ?>
								</div>
								<label class="col-sm-2">Bank City:</label>
								<div class="col-sm-4">
									<?php echo $fee[0]['bank_city'] ?>
								</div>								
								</div>
							</div>
							<div class="clearfix">&nbsp;</div>
									<?php
									}
								  else
									{
									echo '<div class="col-sm-12" style="color:red">
																	The exam form will submit after paying examination fees.
																</div>';
									} ?>
							
							</div>
							<div class="row">
								<div class="col-sm-12" style="align:center">
								<?php
								//if (!empty($sublist) && !empty($fee))
								if (!empty($sublist))
									{
								?>
								<div class="col-sm-4"></div>
								<div class="col-sm-1">
									<input type="submit" name="save" id="save" value="Submit" class="btn btn-primary">
								</div>
								<div class="col-sm-2"><button class="btn btn-primary pull-left" id="btn_cancel" type="button" onclick="window.location='<?php echo base_url($currentModule) ?>/search_exam_form'">Cancel</button></div>	
								<?php
								}
							  else
								{
								} ?>							
								</div>
							</div>
							</div>
						</div>
						</form>
                    </div>
                </div>
			</div>
			</form>
		</div>
			
    </div>
</div>
<style>
.panel-heading {
  color: #4bb1d0;
  background-color: #3da1bf!important;;
  border-color: #4bb1d0;
}
.table,table{width: 100%;max-width: 100%;}
</style>