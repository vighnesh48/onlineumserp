<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/js/bootstrap-multiselect.js"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-multiselect/0.9.13/css/bootstrap-multiselect.css">
<div id="content-wrapper">
	<ul class="breadcrumb breadcrumb-page">
		<div class="breadcrumb-label text-light-gray">You are here: </div>        
		<li class="active"><a href="#">phd_examination</a></li>
		<li class="active"><a href="#">Reports</a></li>
	</ul>
	<div class="page-header">	
		<div class="panel">
			<div class="panel-heading">
				<span class="panel-title">Daywise Exam Reports:</span>
			</div>						

			<div class="row panel-body">
				<div class="col-sm-12">
                
                        
					<form method="post" action="<?=base_url()?>phd_examination/download_daywise_reports_pdf">
							
					<div class="form-group">
						<label class="col-sm-3">Exam Session<sup class="redasterik" style="color:red">*</sup></label>
						<div class="col-sm-3">
							<select name="exam_session" id="exam_session" class="form-control" required>
								<option value="">--Select--</option>
                               
								<?php

								//foreach($exam_session as $exsession){
									$exam_sess = $exam_session[0]['exam_month'] .'-'.$exam_session[0]['exam_year'];
									$exam_sess_val = $exam_session[0]['exam_month'] .'-'.$exam_session[0]['exam_year'].'-'.$exam_session[0]['exam_id'];
									/*if($exam_sess_val == 'JULY-2018-8'){
										$sel = "selected";
									} else{
										$sel = '';
									}*/
									echo '<option value="' . $exam_sess_val. '">' .$exam_sess.'</option>';
								//}
								?></select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3">Dates<sup class="redasterik" style="color:red">*</sup></label>
						<div class="col-sm-3">
							<select name="exam_date[]" id="multiple-checkboxes" multiple="multiple" class="form-control" required>
								<?php
								foreach($ex_dates as $exd){
									if($exd['exam_date'] == $exdool_code){
										$sel = "selected";
									} else{
										$sel = '';
									}
									echo '<option value="' . $exd['exam_date'] . '"' . $sel . '>' . date('d-m-Y',strtotime($exd['exam_date'])) . '</option>';
								}
								?></select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3">Timing<sup class="redasterik" style="color:red">*</sup></label>
						<div class="col-sm-3">
							<select name="exam_timing"  class="form-control" required>
								<option value="">--Select--</option>
								<option value="morning">Morning</option>
								<option value="Afternoon">Afternoon</option>
								<option value="both">Both</option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3">Report Type<sup class="redasterik" style="color:red">*</sup></label>
						<div class="col-sm-3" id="">
							<select name="report_type" id="report_type" class="form-control" required>
								<option value="">Select</option>
								<option value="Daywise" <?php if($_REQUEST['report_type'] =='Daywise'){ echo "selected";}else{}?>>QP Indent </option>
								<option value="Absent" <?php if($_REQUEST['report_type'] =='Absent'){ echo "selected";}else{}?>>Dispatch Performa </option>
								<option value="Answerbooklets" <?php if($_REQUEST['report_type'] =='Answerbooklets'){ echo "selected";}else{}?>>Answer Booklets </option> 
								<option value="marksheets" <?php if($_REQUEST['report_type'] =='marksheets'){ echo "selected";}else{}?>>Marksheets </option>
							</select>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3"></label>
						<div class="col-sm-3" id="">
							<input type="radio" name="download_type" id="download_type" value="PDF" required> PDF &nbsp;&nbsp;
							<input type="radio" name="download_type" id="download_type" value="EXCEL" required> EXCEL
								
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3"></label>
						<div class="col-sm-2" id="">
							<input type="submit" id="" class="btn btn-primary btn-labeled" value="Export" > 
						</div>
					</div>
					<!--<div class="col-sm-3" id="semest">
					<a href="<?=base_url()?>Ums_admission/generateallpdfs">  <input type="button" id="" class="btn btn-primary btn-labeled" value="Generate All" > </a>
					</div>-->
				</div>
				</form>
                       
			</div>    
		</div></div></div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
  
                $("#multiple-checkboxes").multiselect({
               	    maxHeight: 200,
                    //enableCaseInsensitiveFiltering: true,
                    includeSelectAllOption: true
                });
         
        
    });
</script>