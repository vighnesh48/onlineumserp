<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<?php
$ex_ses = str_replace('/','_',$exam);
?>
<script>    
$(document).ready(function()
{
	//$('#exam_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
});

function getExamDate(id){
	$('#'+id).datepicker( {format: 'dd/mm/yyyy',autoclose: true});
	$('#'+id).focus();
	return true;
}
    var base_url = '<?=base_url();?>';
	function load_streams(type){
                   // alert(type);
                    
		$.ajax({
			'url' : base_url + '/Examination/load_streams',
			'type' : 'POST', //the way you want to send data to your URL
			'data' : {'course' : type},
			'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
				var container = $('#semest'); //jquery selector (get element by id)
				if(data){
				 //   alert(data);
					//alert("Marks should be less than maximum marks");
					//$("#"+type).val('');
					container.html(data);
				}
			}
		});
	}
$(document).ready(function(){
			   
	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_schools',
				data: 'school_code=' + school_code,
				success: function (html) {
					//alert(html);
					$('#admission-course').html(html);
				}
			});
		} else {
			$('#admission-course').html('<option value="">Select course first</option>');
		}
	});  
// edit
var school_code = '<?=$school_code?>';

		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_schools',
				data: 'school_code=' + school_code,
				success: function (html) {
					//alert(html);
					var course_id = '<?=$admissioncourse?>';
					$('#admission-course').html(html);
					$("#admission-course option[value='" + course_id + "']").attr("selected", "selected");
				}
			});
		} else {
			
			$('#admission-course').html('<option value="">Select course first</option>');
		}	
		//load streams
		$('#admission-course').on('change', function () {	
		var admission_course = $("#admission-course").val();
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_streams',
				data: 'course_id=' + admission_course,
				success: function (html) {
					//alert(html);
					$('#stream_id').html(html);
				}
			});
		} else {
			$('#stream_id').html('<option value="">Select course first</option>');
		}
	}); 
	// edit
var admission_course = '<?=$admissioncourse?>';

		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_streams',
				data: 'course_id=' + admission_course,
				success: function (html) {
					//alert(html);
					var stream_id = '<?=$stream?>';
					$('#stream_id').html(html);
					$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
				}
			});
		} else {
			
			$('#stream_id').html('<option value="">Select course first</option>');
		}
		/*$('#btn_download_form1').on('click', function () {	
    	var stream_id = '<?=$stream?>';
		var exsess = '<?=$exam?>';
		var report_type = '<?=$report_type?>';
		var reval_type = '<?=$reval_type?>';
		//alert(report_type);
    	window.location.href = '<?= base_url() ?>Reval/download_studentwise_pdf/'+stream_id+'/'+exsess+'/'+report_type+'/'+reval_type;
    	
	}); */	
	$('#btn_download_excel').on('click', function () {	
    	var stream_id = '<?=$stream?>';
		var exsess = '<?=$ex_ses?>';
		var report_type = '<?=$report_type?>';
		var reval_type = '<?=$reval_type?>';
		//alert(report_type);
    	window.location.href = '<?= base_url() ?>Reval/excel_summary_report/'+stream_id+'/'+exsess+'/'+report_type+'/'+reval_type;
	}); 
});
</script>
<?php 
if(isset($role_id) && $role_id==1 ){
?>
<style>
	.table{width: 150%;}
	table{max-width: 150%;}
</style>									
<?php }else{ ?>
	<style>
	table.dataTable{width: 210%;}</style>
<?php }?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Results</a></li>
        <li class="active"><a href="#"></a></li>
    </ul>
    <div class="page-header">
    	<div class="row">
            <h1 class="col-xs-12 col-sm-8 text-center text-left-sm"><i class="fa fa-list page-header-icon"></i>&nbsp;&nbsp;Photocopy / Revaluation Summary Report</h1>
            <div class="col-xs-12 col-sm-4">
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
                        <span class="panel-title">
                            <form method="post" action ="<?=base_url()?>Reval/summary_report">	
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							 <div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required>
                                 <option value="">Exam Session</option>
                               
                                  <?php

									foreach ($exam_session as $exsession) {
										$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'].'-'.$exsession['exam_id'];
									    if ($exam_sess == $_POST['exam_session']) {
									        $sel = "selected";
									    } else {
									        $sel = '';
									    }
									    echo '<option value="' . $exam_sess. '"' . $sel . '>' .$exsession['exam_month'] .'-'.$exsession['exam_year'].'</option>';
									}
									?></select>
                              </div>
							<div class="col-sm-2">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select School</option>
                                 <option value="0">All School</option>
                                  <?php
									foreach ($schools as $sch) {
									    if ($sch['school_code'] == $school_code) {
									        $sel = "selected";
									    } else {
									        $sel = '';
									    }
									    echo '<option value="' . $sch['school_code'] . '"' . $sel . '>' . $sch['school_short_name'] . '</option>';
									}
									?></select>
                              </div>
                              <div class="col-sm-2">
                                <select name="admission-course" id="admission-course" class="form-control" required>
                                 <option value="">Select Course</option>
                                  <option value="0">All Courses</option>
                                  </select>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-2" id="semest">
                                <select name="admission-branch" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
							  <input type="hidden" name="report_type" id="report_type" value="subjectwise">
                              <!--div class="col-sm-2">
                                <select name="report_type" id="report_type" class="form-control" required>
                                	<option value="">--SELECT--</option>
                                	<option value="subjectwise" <?php if($report_type=='subjectwise'){ echo "selected";}?>>Subject-wise</option>
                                	<!--option value="studentwise" <?php if($report_type=='studentwise'){ echo "selected";}?>>Student-wise</optio>
								</select>
                              </div-->
							  <div class="col-sm-2">
                                <select name="reval_type" id="reval_type" class="form-control" required>
                                  <option value="">Select Type</option>
                                  <option value="1" <?php if($_REQUEST['reval_type']==1){ echo "selected";}?>>Revaluation</option>
                                  <option value="0" <?php if($_REQUEST['reval_type']==0){ echo "selected";}?>>Photocopy</option>
                                  </select>
                              </div>
                              <div class="col-sm-2">
                                 <input type="submit" id="" class="btn btn-primary btn-labeled" value="Search" > 
                            </div>
                             <!--<div class="col-sm-3" id="semest">
                               <a href="<?=base_url()?>Ums_admission/generateallpdfs">  <input type="button" id="" class="btn btn-primary btn-labeled" value="Generate All" > </a>
                            </div>-->
                            </div>
                            </form>
                        </span>
                        <div class="holder1"></div>
                </div>

            <div class="table-info panel-body" >  
            	<div id="rgm" style="color:green;margin-left: 15px;"><div id="resp" style="display:none;"><img src='<?=base_url()?>assets/images/demo_wait_b.gif' /></div></div>
			<?php 
			$role_id=$this->session->userdata('role_id');
			?>
           

            <input type="hidden" name="stream_id" value="<?=$stream?>">
			<input type="hidden" name="adm_semester" value="<?=$semester?>">
				<?php// }?>
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" style="<?=$tbstyle?>">    
				<?php 	
					if($_POST){
				
				?>
			
<?php
$CI =& get_instance();
$CI->load->model('Reval_model');
//echo "<pre>";
//print_r($stream_list);
foreach ($stream_list as $value) {

?>
            <table class="table table-bordered">
			<tr>
            <td  width="15%" valign="middle">&nbsp;<strong>Program:</strong></td>
            <td valign="middle" colspan='3'>&nbsp;<?=$value['stream_name']?></td>
            </tr>
             </table>
            <table class="table table-bordered" style="margin-top:-25px;">
                        <thead>
                            <tr >
                                <th>S.No.</th>
                                <th>Course Code</th>    
                                <th>Semester</th>
                                <th>Course Name</th>
                                <th>No. of Applied </th>           
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        <?php 
						$exam_month= str_replace('/','_',$exam_month);
                        $result_data = $school_code.'~'.$stream.'~'.$exam_month.'~'.$exam_year.'~'.$exam_id;
                        ?>
                              <input type="hidden" id="res_data" name="res_data" value="<?=$result_data?>">

                            <?php
                           //echo "<pre>";
                            //print_r($subject_list);
                            //$enrollment_no='';
                            $i=0; 
                            $j=1;
                            if(!empty($value['subject_list'])){                          
                            foreach ($value['subject_list'] as $val) {
                                $sub_stud =$this->Reval_model->fetch_revalsub_students($value['stream_id'], $val['subject_id'],$exam_id, $reval_type);
                               //echo $value['isPresent']; 
                            ?>              
                            <tr >
                              <td align="center" rowspan="2" width="10%"><?=$j?></td>
                                <td align="center" width="15%"><?=$val['subject_code']?></td> 
                                <td align="center" width="10%"><?=$val['semester']?></td> 
                                <td><?=$val['subject_name']?></td>
                                <td align="center" width="15%"><?=count($sub_stud);?></td>
    
                            </tr>
                            <?php
                            foreach ($sub_stud as $stud) {
                               //echo $value['isPresent']; 
                                $enrollment_no[] = $stud['enrollment_no'];
                            } ?>
                            <tr>
                                
                              <td colspan=4 style="word-wrap: break-word;"><?=implode(', ', $enrollment_no);?></td>     
                            </tr>

                            <?php
                            $j++;
                            $i++;
                            unset($enrollment_no);
                            }
                        }else{
                            echo "<tr><td colspan='6'>No data found.</td></tr>";
                        }
                            ?> <br>                           
                       
                        </tbody>
                    </table>   
                    <br>
                    <?php } ?>     
                    <button class="btn btn-primary pull-right" id="btn_download_form" type="button">Download PDF</button> &nbsp;&nbsp;&nbsp;
					
					<button class="btn btn-primary pull-right" id="btn_download_excel" Style="margin-right:50px;" type="button">Download Excel</button> &nbsp;&nbsp;&nbsp;
                    <?php } ?>
                </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
		$('#btn_download_form').on('click', function () {	
    	var stream_id = '<?=$stream?>';
		var exsess = '<?=$ex_ses?>';
		alert(exsess);
		var report_type = '<?=$report_type?>';
		var reval_type = '<?=$reval_type?>';
    	window.location.href = '<?= base_url() ?>Reval/download_summary_report/'+stream_id+'/'+exsess+'/'+report_type+'/'+reval_type;
	}); 
});
</script>