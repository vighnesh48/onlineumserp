<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style type="text/css">.loader {
  border: 6px;
  border-radius: 50%;
  border-top: 6px solid pink;
  border-bottom: 6px solid pink;
  width: 90px;
  height: 90px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  margin-left:50%;
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
  
    
<style>
.absent_bg{background:#ff9b9b;}
</style>
<?php
    $sess='';
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
    $role_id=$this->session->userdata('role_id');
	$emp_id = $this->session->userdata("name");
	$ex =explode("_",$emp_id);
	$sccode = $ex[1];
	$acad_year=$this->config->item('current_year');
	if($this->config->item('current_sess')=='WIN'){ $sess='WINTER';}else{ $sess='SUMMER';}
	$yrsession=$acad_year.'~'.$sess;
	if($role_id==44 || $role_id==20){
	$CI =& get_instance();
    $CI->load->model('Subject_model');
	$empsch = $CI->Subject_model->loadempschool($emp_id);
	$schid= $empsch[0]['school_code'];
	}
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Project</a></li>
        <li class="active"><a href="#">Attendance</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Daywise Attendance Report</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                    <div class="panel-heading">
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                           	<div class="form-group">
                              <div class="col-sm-2" >
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
                                    foreach ($academic_year as $value) {
                                      echo '<option value="'.$value['academic_year'].'">'.$value['academic_year'].'</option>';
                                    }
                                            
                                  ?>
                                </select>
                              </div>
								              <div class="col-sm-2" >
                                <select name="school_id" id="school_id" class="form-control" >
                                  <option value="">Select School</option>
                                    <?php
							                  	  	foreach ($sch_list as $value) { ?>

							                  	  		<option value="<?=$value['school_code']?>"<?php if($role_id==10){ if($value['school_code']==$sccode){echo "selected='Selected'";}}if($role_id==44 || $role_id==20){if($value['school_code']==$schid){echo "selected='Selected'";}}?>><?=$value['school_short_name']?>
                                      
							                  	  		</option>
							                  	  <?php } ?>
                               </select><sup class="redasterik" style="color:red">*</sup>
                              </div>
								              <div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" required>
                                  <option value="">Select Course</option>
                                </select>
                              </div> 
                              <div class="col-sm-2" >
                                <select name="stream_id" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                                </select>
                              </div>							

							                <div class="col-sm-2" >
                               <input type="text" class="form-control" name="from_date" id="dt-datepicker1" value="<?=date('Y-m-d')?>" placeholder="From Date" required><sup class="redasterik" style="color:red">*</sup>
                              </div>
                              <div class="col-sm-2" >
                                <input type="text" class="form-control" name="to_date" id="dt-datepicker2" value="<?=date('Y-m-d')?>"  placeholder="To Date" required><sup class="redasterik" style="color:red">*</sup>
                              </div>   

                              <div class="col-sm-10"></div>             
								              <div class="col-sm-2">
                                <button class="btn btn-primary form-control" id="btn_submit" type="button" >Search</button> </div>
                              </div>
                          </div>
                      </div>
                  </div>
            </div>    
        </div>
		  <div class="row ">		   
            <div class="col-sm-12">
				<div class="panel">				 
                    <div class="panel-body" style="overflow:scroll;">
                     <div id="wait" style="display:none;"><div class="loader"></div><br>Loading..</div>
						<div class="col-sm-12">
                        <div class="table-info" id="studtbl" >  

							
						</div>
                    </div>
                </div>
			</div>
			
		</div>
			
    </div>
</div>

<script>
$(document).ready(function () {
	//$(document).ajaxStart(function(){
		//alert('ff');
   // $("#wait").css("display", "block");
 // });
  //$(document).ajaxComplete(function(){
   // $("#wait").css("display", "none");
  //});
  <?php if($role_id==10 || $role_id==20 || $role_id==44 ){ ?>
   $('#btn_submit').trigger('click');
  <?php } ?>
		$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
		$('#dt-datepicker2').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
	
	 $('#school_id').on('change', function () {
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?><?=$currentModule?>/get_courses',
			data: {school_id:$(this).val()},
			success: function (html) {
				//alert(html);
				var course_id = '<?=$courseId?>';
				$('#course_id').html(html);

			}
		});
	});
	$('#course_id').on('change', function () {
    var sch_id=$('#school_id').val();
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?><?=$currentModule?>/get_stream',
			data: {course_id:$(this).val(),sch_id:sch_id},
			success: function (html) {				
				$('#stream_id').html(html);
			}
		});
	});

		
});
		$('#btn_submit').click(function(){
var acd_yer =$('#academic_year').val();
var sch_id = $('#school_id').val();
var cur = $('#course_id').val();
var strm = $('#stream_id').val();
var fdt = $('#dt-datepicker1').val();
var tdt = $('#dt-datepicker2').val();


	//alert('fgfgdf');
  if( fdt=='' || tdt==''){
alert('Select Required Fields(*).');
  }else{
    $("#wait").css("display", "block");
$.ajax({
				'url' : base_url + 'Project/get_mark_report',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'sch_id' : sch_id,'curs':cur,'strm':strm,'fdt':fdt,'tdt':tdt,'acd_yer':acd_yer},
				'success' : function(data){ 
					//jquery selector (get element by id)
					if(data){
						//alert(data);
						$('#studtbl').html(data);
						$("#wait").css("display", "none");
					}
				}
			});
}

		});

	</script>
	

	