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
/* 	if($role_id==44 || $role_id==20){
	$CI =& get_instance();
    $CI->load->model('Subject_model');
	$empsch = $CI->Subject_model->loadempschool($emp_id);
	$schid= $empsch[0]['school_code'];
	} */
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
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
                            <span class="panel-title">Current Session: <?=$this->config->item('current_year')?>(<?php if($this->config->item('current_sess')=='WIN'){ echo 'WINTER'; }else{ echo 'SUMMER'; }?>)</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                           	<div class="form-group">
                            <div class="col-sm-2" >
                                <select name="academic_year" id="academic_year" class="form-control" required >
                                  <option value="">Select Academic Year</option>
                                  <?php
                  foreach ($academic_year as $yr) {
                    if ($yr['academic_year'].'~'.$yr['academic_session'] == $yrsession) {
                      $sel = "selected";
                    }else {
                      $sel = '';
                    }
					if($role_id==10 || $role_id==20 || $role_id==44 )
					{
						if($yr['academic_year'].'~'.$yr['academic_session']==$yrsession)
						{
							$sel="selected";
						}
					}
                    echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session'].'"' . $sel . '>' . $yr['academic_year'].' ('.$yr['academic_session'] . ')</option>';
                  }

                  ?>
                  <!-- <option value="2018-19~SUMMER">2018-19(SUMMER)</option> -->
				  
                               </select>
                              </div>
								
                                	<div class="form-group">
							            <div class="col-sm-2" >
                               <input type="text" class="form-control" name="from_date" id="dt-datepicker1" value="<?=date('Y-m-d')?>" placeholder="From Date" required ><sup class="redasterik" style="color:red">*</sup>
                              </div>
                              <div class="col-sm-2" >
                              <input type="text" class="form-control" name="to_date" id="dt-datepicker2" value="<?=date('Y-m-d')?>"  placeholder="To Date" required ><sup class="redasterik" style="color:red">*</sup>
                              </div>           
                                  <div class="col-sm-2" >
                                <select name="sub_type" id="sub_type" class="form-control" required >
                                  <option value="">Select Subject Type</option>
                                  <option value="" selected>ALL</option>
                                  <option value="TH" >Theory</option>
                                  <option value="PR">Practical</option>
                               </select>
                              </div> 
       
								<div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_submit" type="button" >Search</button> </div>
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


   $('#btn_submit').trigger('click');

		$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
		$('#dt-datepicker2').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});		
    });
	
$('#btn_submit').click(function(){
var acd_yer =$('#academic_year').val();
var fdt = $('#dt-datepicker1').val();
var tdt = $('#dt-datepicker2').val();
var sub_type = $('#sub_type').val();
      
	   if(acd_yer =='' || fdt=='' || tdt=='' )
	   {
		   alert("All Fields Required");
	   }else
	   {   
      if(fdt > tdt)
	  {
		  alert('From Date Must be Less than To Date');
	  }
	  else
	  {
    $("#wait").css("display", "block");
$.ajax({
				'url' : base_url + 'Student_attendance/get_rolewise_attendance_mark_report',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'fdt':fdt,'tdt':tdt,'acd_yer':acd_yer,'sub_type':sub_type},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					//jquery selector (get element by id)
					//alert(data);
					if(data){
						
						$('#studtbl').html(data);
						$("#wait").css("display", "none");
					}
				}
			});
	       }
	      }
		});

	</script>
	

	