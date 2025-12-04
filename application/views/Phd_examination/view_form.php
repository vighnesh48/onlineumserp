<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
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
 <div style="color:green">
		  <?php
		  if(!empty($this->session->flashdata('success'))){
			  echo $this->session->flashdata('success');
		  }
		  ?></div>	
 <div style="color:red">
		  <?php
		  if(!empty($this->session->flashdata('duplicate'))){
			  echo $this->session->flashdata('duplicate');
		  }
		  ?></div>			  
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
		  <div class="row ">
		 
			<form id="form" name="form" action="<?=base_url($currentModule.'/add_exam_form')?>" method="POST">    

			<div class="col-sm-12">
				<div class="panel">
                    <div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">Personal Details</span>
                    </div>
                    <div class="panel-body">
					<form name="exam_form" method="POST" action="<?=base_url($currentModule.'/add_exam_form')?>">
                        <div class="table-info">  
						<table class="table table-bordered">
    					<tr>
    					  <th width="12%">PRN No :</th>
						  <td width="38%"><?=$emp[0]['enrollment_no']?></td>
						  <th width="12%">Exam Name :</th>
						  <td width="38%"><?=$exam[0]['exam_month']?>-<?=$exam[0]['exam_year']?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name :</th>
						  <td><?=$emp[0]['last_name']?> <?=$emp[0]['first_name']?> <?=$emp[0]['middle_name']?></td>
						   <th width="25%">DOB:</th>
						   <td><?=$emp[0]['dob']?> </td>
						</tr>
						<tr>
    					  <th scope="col">Course Name :</th>
						  <td><?=$emp[0]['stream_name']?></td>
						   <th width="25%">School :</th>
						   <td><?=$emp[0]['school_code']?>-<?=$emp[0]['school_name']?></td>
    					</tr>

						</table>
						<div class="panel-heading">
                            <span class="panel-title" style="color:#FFF">Subject Appeared</span>
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
							<input type="hidden" name="exam_details" value="<?=$exam[0]['exam_id']?>~<?=$exam[0]['exam_month']?>~<?=$exam[0]['exam_year']?>~<?=$exam[0]['exam_type']?>">
							<input type="hidden" name="stream_id" value="<?=$emp[0]['admission_stream']?>">
							<input type="hidden" name="semester" value="<?=$emp[0]['admission_semester']?>">
							<input type="hidden" name="student_id" value="<?=$emp[0]['stud_id']?>">
							<input type="hidden" name="enrollment_no" value="<?=$emp[0]['enrollment_no']?>">
							<input type="hidden" name="school_code" value="<?=$emp[0]['school_code']?>">
								<?php
								$i=1;
									if(!empty($sublist)){
										foreach($sublist as $sub){
								?>
								<tr>
									
									<td><?=$i;?> &nbsp; &nbsp;<input type="hidden" name="sub[]" value="<?=$sub['sub_id']?>~<?=$sub['subject_code1']?>"></td>
									<td><?=$sub['subject_code']?></td>
									<td><?=$sub['subject_name']?></td>
									<td><?=$sub['semester']?></td>
									
									
								</tr>
								<?php 
									$i++;
									}
									}else{
										echo "<tr><td colspan=4>No data found.</td></tr>";
									}
								?>
								</tbody>
							</table>
							<div class="panel">
							<div class="panel-heading">
								<span class="panel-title" style="color:#FFF">Fees Details <div class="pull-right"> Applied Fees: <?=$examdetails[0]['exam_fees']?></div></span>
							</div>
							<div class="clearfix">&nbsp;</div>
							<?php 
							$exam_type= $exam[0]['exam_type'];
							if($exam_type=='Regular'){
								
							
							?>
							<div class="row">
								<div class="col-sm-12">
								<table class="table table-bordered" >
									<thead1>
										<tr>
											<th>Payment Type</th>
											<th>Recept No</th>
											<th>Date</th>
											<th>Amount</th>
											<th>Bank Name</th>
											<th>Bank City</th>
										</tr>
									</thead1>
									<tbody>
										<?php
										$i = 1;

										if (!empty($fee))
											{
										?>
										<tr>
											<td><?php echo $fee[0]['fees_paid_type'] ?></td>
											<td><?php echo $fee[0]['receipt_no'] ?></td>
											<td><?php
													if ($fee[0]['fees_date'] != '' && $fee[0]['fees_date'] != '0000-00-00')
														{
														echo date('d/m/Y', strtotime($fee[0]['fees_date']));
														}

												?>
													
											</td>
											<td><?php echo $fee[0]['amount'] ?></td>
											<td><?php echo $fee[0]['bank_name'] ?></td>
											<td><?php echo $fee[0]['bank_city'] ?></td>
										</tr>
										<?php
									}
								  else
									{
									echo '<tr><td colspan="6" style="color:red"><!--Examination fees not paid.--> </td></tr>';
									} ?>
									</tbody>

								</table>
								</div>	
							</div>	</div>	
							<div class="clearfix">&nbsp;</div>
							<?php }?>
							<div class="col-sm-2"><button class="btn btn-primary pull-left" id="btn_cancel" type="button" onclick="window.location='<?=base_url($currentModule)?>/search_exam_form'">Back</button></div>								
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

