<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Phd Degree Certificate Assign</a></li>
        <!--<li class="active"><a href="<?=base_url($currentModule)?>">Fees Master </a></li>-->
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-5 text-ctext-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student List </h1>            
        </div>
        <div class="row ">
            <div class="col-sm-12">
                   <form id="form" name="form" action="<?=base_url($currentModule.'/phd_cert_edit_submit')?>" method="POST" >
                             
                           <div class="col-md-6" id="std_details" style="padding-right:0px;">
							<div class="panel">                  
							<div class="panel-heading">
							<b>Student Details:</b>
							</div>							
                            <div class="panel-body">							
							<input type="hidden" id="gc_id" name="gc_id" value="<?=$stud_details[0]['gc_id'];?>" />
							<input type="hidden" id="stud_id" name="stud_id" value="<?=$stud_details[0]['student_id'];?>" />
							<input type="hidden" id="exam_session" name="exam_session" value="<?=$stud_details[0]['exam_month'].'~'.$stud_details[0]['exam_year'].'~'.$stud_details[0]['exam_id']?>" />
							<input type="hidden" id="school" name="school" value="<?=$stud_details[0]['school_id']?>" />
							<input type="hidden" id="stream_id" name="stream_id" value="<?=$stud_details[0]['stream_id']?>" />
                              <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Student Name:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 <input type="text" id="stud_name" name="stud_name" value="<?=$stud_details[0]['first_name'].' '.$stud_details[0]['middle_name'].' '.$stud_details[0]['last_name']?>" class="form-control" readonly />
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Enrollment No:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 <input type="text" id="enroll" name="enroll" value="<?=$stud_details[0]['enrollment_no']?>" class="form-control" readonly  />
								   </div>			 
							  </div>
							  <!--div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Exam Month/Year:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 <input type="text" id="month_year" name="month_year" value="<?=$stud_details[0]['exam_month'].' / '.$stud_details[0]['exam_year']?>" class="form-control" readonly />
								   </div>			 
							  </div-->
							  <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Certificate Dispatch:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 <input type="text" id="cert_disp" name="cert_disp" value="<?=$stud_details[0]['certificate_dispatch']?>" class="form-control" />
								   </div>			 
							  </div>
							  <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Thesis Name:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 <input type="text" id="thesis_name" name="thesis_name" value="<?=$stud_details[0]['thesis_name']?>" class="form-control" />
								   </div>			 
							  </div>
							  	  <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Faculty Name:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 <input type="text" id="fac_name" name="fac_name" value="<?=$stud_details[0]['faculty_name']?>" class="form-control" />
								   </div>			 
							  </div>
							  	  <div class="form-group">
								<label class="col-md-4" style="padding-left:0px;">Exam Session:</label>
									 <div class="col-md-7" style="padding-left:20px;" >
									 <input type="text" id="issue_date" name="issue_date" value="<?=$stud_details[0]['issued_date']?>" class="form-control" />
								   </div>			 
							  </div>
							  <div class="form-group">
							     <div class="col-sm-4"></div>
                                    <div class="col-sm-2">
                                        <button class="btn btn-primary form-control" id="btn_submit" type="submit" >Submit</button>
                                       
                                        </div>
							         </div>
						          </div>
						      </div>  
                           </div>
				        </form>
                    </div>
               </div>
         </div>   		
    </div>
</div>
<script>
$(document).ready(function (){
	
	$('#gmarkscard1').click(function(){

	  var cert_disp_id=$("#cert_disp").val();
	  var thesis=$("#thesis_name").val();
	  var faculty=$("#fac_name").val();
	  var mrk_cer_date=$("#issue_date").val();
	  var chk_stud=$("#stud_id").val();
	  var gc_id=$("#gc_id").val();
      var report_type ='pdf';
      var exam_session =$("#exam_session").val();
      var stream_id =$("#stream_id").val();
      var school =$("#school").val();
	  if (cert_disp_id !='' && thesis!='' && faculty!='' && mrk_cer_date!='') {
				$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Phd_results/generate_degree_certificate_pdf',
				data: 'cert_disp_id=' +cert_disp_id+'&thesis='+thesis+'&faculty=' +faculty+'&mrk_cer_date='+mrk_cer_date+'&chk_stud='+chk_stud+'&report_type='+report_type+'&gc_id='+gc_id+'&exam_session='+exam_session+'&stream_id='+stream_id+'&school='+school,
				success: function (html) {}
			});
			} else {
				alert("Some Data Missing");
			}
	});
});	
</script>