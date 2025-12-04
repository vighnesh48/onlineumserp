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
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="<?=base_url($currentModule)?>">Canteen </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Canteen</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
			
			<span id="flash-messages" style="color:Green;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message1'))){ echo $this->session->flashdata('message1'); } ?></span>
					<span id="flash-messages" style="color:red;padding-left:50px;">
						 <?php if(!empty($this->session->flashdata('message2'))){ echo $this->session->flashdata('message2'); } ?></span>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                        <span class="panel-title">Student Details</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">   
						<table class="table table-bordered">
    					<tr>
    					  <th width="17%">PRN No:</th><td width="35%"><?=$student_details['enrollment_no']?></td>
    					  <th width="17%">Institute:</th><td width="35%"><?=$student_details['school_name']?></td>
						</tr>
						<tr>
						  <th scope="col">Student Name:</th><td><?=$student_details['last_name']?> <?=$student_details['first_name']?> <?=$student_details['middle_name']?></td>
						  <th width="15%">Academic Year:</th><td><?= isset($stud_details['academic_year']) ? $stud_details['academic_year'] : '' ?></td>
						</tr>
						<tr>
    					  <th scope="col">Course Name:</th>
					<td id="prgm_id"><?php  if($student_details['course']==NULL)//echo $student_details['course_short_name'].' '.
					echo $student_details['stream_short_name'].$student_details['stream'];else echo $student_details['course'].' '.$student_details['stream']?></td>
    					  <th width="15%">Year:</th><td><?=$student_details['current_year']?></td>
    					</tr>
						<!-- -----------------------------  Addded a dropdown for canteen  ---------------------------- -->
						<tr>
							
								<th>Canteen:</th>
								<td>
								

								<?php
									foreach($canteen_id as $canteen) {
										foreach ($canteen_details as $key => $value) { 
											if($value['id']==$canteen['allocated_id']) {
												if($canteen['cs_id'] == 1) {
													echo 'Breakfast: ', $value['cName'],'</br>'; 
												}elseif($canteen['cs_id'] == 2) {
													echo 'Lunch: ', $value['cName'],'</br>';
												}else{
													echo 'Dinner: ', $value['cName'];
												}
												
												} 
											   }
									}
									 

									 
									
									  ?>
								
								</td>
							
						</tr>
						<!-- -----------------------------  End of dropdown for canteen  ---------------------------- -->
						</table>
                      </div>
            

</div>


