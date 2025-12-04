<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
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
		$('#btn_download_form').on('click', function () {	
    	var stream_id = '<?=$stream?>';
		var exsess = '<?=$batch?>';
		var report_type = '<?=$report_type?>';
		var courseid = '<?=$admissioncourse?>';
		var schoolcode = '<?=$school_code?>';
		//alert(report_type);
    	window.location.href = '<?= base_url() ?>Results/download_arrear_report/'+schoolcode+'/'+courseid+'/'+stream_id+'/'+exsess+'/'+report_type;
	}); 
	$('#btn_download_excel').on('click', function () {	
    	var stream_id = '<?=$stream?>';
		var exsess = '<?=$batch?>';
		var report_type = '<?=$report_type?>';
		var courseid = '<?=$admissioncourse?>';
		var schoolcode = '<?=$school_code?>';
		//alert(schoolcode);
    	window.location.href = '<?= base_url() ?>Results/download_excel_arrear_report/'+schoolcode+'/'+courseid+'/'+stream_id+'/'+exsess+'/'+report_type;
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-list page-header-icon"></i>&nbsp;&nbsp;Arrear Report</h1>
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
                        <span class="panel-title">
                            <form method="post" action ="<?=base_url()?>Results/arrear_report">	
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							 <!--div class="col-sm-2">
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
                              </div-->
							  <div class="col-sm-2">
                                <select name="batch" id="batch" class="form-control" required>
                                 <option value="">Select Batch</option>
                               <option value="0">All Batches</option>
                                  <?php

									foreach ($batches as $bt) {
										$exam_sess = $exsession['batch'];
									    if ($bt['batch'] == $batch) {
									        $sel = "selected";
									    } else {
									        $sel = '';
									    }
									    echo '<option value="' . $bt['batch']. '"' . $sel . '>'.$bt['batch'].'</option>';
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
                              <div class="col-sm-2">
                                <select name="report_type" id="report_type" class="form-control" required>
                                	<option value="">--SELECT--</option>
                                	<option value="subjectwise" <?php if($report_type=='subjectwise'){ echo "selected";}?>>Subject-wise</option>
                                	<option value="studentwise" <?php if($report_type=='studentwise'){ echo "selected";}?>>Student-wise</option>
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
						$CI =& get_instance();
$CI->load->model('Results_model');
				if($report_type=='subjectwise'){
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
 <table class="table table-bordered" id="">
                        <thead>
                            <tr>
                                    <th>S.No.</th>
									<th>Course Code</th>	
                                    <th>Semester</th>
                                     <th>Course Name</th>
									 <th>Batch</th>
									 <th>No. of Arrear(s) </th>           
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        <?php 
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
                               $sub_stud =$this->Results_model->fetch_arrear_students($value['stream_id'], $val['subject_id'],$exam_id='');
                            ?>				
                            <tr>
                              <td rowspan="2"><?=$j?></td>
								<td><?=$val['subject_code']?></td> 
								<td><?=$val['semester']?></td> 
								<td><?=$val['subject_name']?></td>
								<td><?=$val['batch']?></td>
								<td><?=count($sub_stud);?></td>
	
                            </tr>
                            <?php
                            foreach ($sub_stud as $stud) {
                               //echo $value['isPresent']; 
                            	$enrollment_no[] = $stud['enrollment_no'];
                        	} ?>
                        	<tr>
                        		
                              <td colspan=5 style="word-wrap: break-word;"><?=implode(', ', $enrollment_no);?></td>		
                            </tr>
                            <?php
                            $j++;
                            $i++;
                            unset($enrollment_no);
                            }
                        }else{
                        	echo "<tr><td colspan='6'>No data found.</td></tr>";
                        }
                            ?>                            
                        
                        </tbody>
                    </table> 
                    
                    <?php 
					}
				
				}elseif($report_type=='studentwise'){
foreach ($stream_list as $value) {
				?>
<table class="table table-bordered">
			<tr>
            <td  width="15%" valign="middle">&nbsp;<strong>Program:</strong></td>
            <td valign="middle" colspan='3'>&nbsp;<?=$value['stream_name']?></td>
            </tr>
             </table>				
<table class="table table-bordered">
    <thead>
        <tr>
            <th>S.No.</th>
            <th>PRN</th>    
            <th>Name</th>
            <th>Sem</th> 
            <th>Course Code</th>
            <th>Course Name</th>
            <th>No. of arrear(s)</th>        
        </tr>
    </thead>
    <tbody id="studtbl">
        <?php
        //echo "<pre>";
        // print_r($student_list);exit;
        //$enrollment_no='';
        $i=0; 
        $j=1;
        $k=1;
        if(!empty($value['student_list'])){                          
        foreach ($value['student_list'] as $val) {
		$stud_sub_applied= $this->Results_model->stud_arrear_subject_list($value['stream_id'], $val['student_id'],$batch,$exam_id='');
           $cnt_sub = count($stud_sub_applied);
           //$cnt_sub = $cnt_sub+1;
		   
        ?>              
        <tr >
          <td rowspan="<?=$cnt_sub?>" align="center"><?=$j?></td>
            <td rowspan="<?=$cnt_sub?>" align="center"><?=$val['enrollment_no']?></td> 
            <td rowspan="<?=$cnt_sub?>"><?=$val['stud_name']?></td> 
            <td align="center"><?=$stud_sub_applied[0]['semester']?></td>
            <td align="center"><?=$stud_sub_applied[0]['subject_code']?></td>
            <td><?=$stud_sub_applied[0]['subject_name']?></td> 
            <td rowspan="<?=$cnt_sub?>" align="center"><?=count($stud_sub_applied);?></td>    
        </tr>
        <?php 
            //foreach ($student_list[$i]['stud_sub_applied'] as $sub) {
            for($k=1; $k < $cnt_sub; $k++){    
            ?>
            <tr>
                <td align="center"><?=$stud_sub_applied[$k]['semester']?></td>
                <td align="center"><?=$stud_sub_applied[$k]['subject_code']?></td>
                <td><?=$stud_sub_applied[$k]['subject_name']?></td>
            </tr>
                <?php 
                   }
                ?>
        <?php

        $j++;
        $i++;
        }
    }
     ?>                            
    </tbody>
    </table> <br>
<?php } 

}else{
						
					}
					
					?>
					<button class="btn btn-primary pull-right" id="btn_download_form" type="button">Download PDF</button> 
<button class="btn btn-primary pull-right" id="btn_download_excel" Style="margin-right:50px;" type="button">Download Excel</button> &nbsp;&nbsp;&nbsp;					
				<?php }?>
                </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
