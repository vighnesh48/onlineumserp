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
			'url' : base_url + '/Marks/load_cia_streams',
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
				url: '<?= base_url() ?>Marks/load_cia_streams',
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
	$('#stream_id').on('change', function () {
			var stream_id = $(this).val();
			var exam_session = $("#exam_session").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Cia_session/load_cia_semester',
					data: {stream_id:stream_id,exam_session:exam_session},
					success: function (html) {
						//alert(html);
						$('#semester').html(html);
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		});
		
		var stream_id1 = '<?=$stream?>';
		var exam_sess_id = '<?=$exam?>';
			if (stream_id1) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Marks/load_cia_semester',
					data: {stream_id:stream_id1,exam_session:exam_sess_id},
					success: function (html) {
						//alert(html);
						var semester1 = '<?=$semester?>';
						$('#semester').html(html);
						$("#semester option[value='" + semester1 + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
	// edit
var admission_course = '<?=$admissioncourse?>';

		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Marks/load_cia_streams',
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
        <li class="active"><a href="#">Examination</a></li>
        <li class="active"><a href="#">Marks</a></li>
    </ul>
    <div class="page-header">
<form method="post" action ="<?=base_url()?>marks/cia_report">	
        <div class="row">
            <h1 class="col-xs-12 col-sm-2 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;CIA Report </h1>
			<div style="padding-top:5px;"><input type="hidden" name="marks_type" id="marks_type2" value="CIA" ></div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">
                            
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							 <div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required>
                                 <option value="">Exam Session</option>
                               
                                  <?php

foreach ($exam_session as $exsession) {
	$exam_sess_val = $exsession['exam_month'] .'-'.$exsession['exam_year'] .'-'.$exsession['exam_id'];
	$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
    if ($exam_sess_val == $_POST['exam_session']) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $exam_sess_val. '"' . $sel . '>' .$exam_sess.'</option>';
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
                              <div class="col-sm-2" id="">
                                <select name="semester" id="semester" class="form-control" required>
                                  <option value="">Select Semester</option>
                                  </select>
                             </div>
							 <!--div class="col-sm-2" id="">
                                <select name="marks_type" id="marks_type" class="form-control" required>
                                  <option value="">Marks Type</option>
                                   <option value="CIA" <?php if($_REQUEST['marks_type'] =='CIA'){ echo "selected";}else{}?>>CIA </option>
								   <option value="TH" <?php if($_REQUEST['marks_type'] =='TH'){ echo "selected";}else{}?>>TH </option>
								   <option value="PR" <?php if($_REQUEST['marks_type'] =='PR'){ echo "selected";}else{}?>>PR </option>
								   <option value="OR" <?php if($_REQUEST['marks_type'] =='OR'){ echo "selected";}else{}?>>OR </option>
								   <option value="PJ" <?php if($_REQUEST['marks_type'] =='PJ'){ echo "selected";}else{}?>>PJ </option>

                                  </select>
                             </div-->
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

            <div class="table-info panel-body" style="overflow-x:scroll;height:500px; overflow-y:scroll;width:100%;">  
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" >    
				<?php 	
					if($_POST){
						$var_cia = $stream.'~'.$semester.'~'.$exam_month.'~'.$exam_year.'~'.$exam_sess_id;	
						$var_cia = str_replace('/','_', $var_cia);
									
				?>
				<?php 
				if($stream !='' && $semester !=''){
					?>
				<!--a href="<?=base_url()?>Marks/excel_CIAReport/<?=$var_cia?>"><span class="btn-primary btn pull-left" style="margin-left: 1px;">Export Excel</span></a--> &nbsp;&nbsp;
								<a href="<?=base_url()?>Marks/pdf_CIAReport/<?=$var_cia?>"><span class="btn-primary btn pull-left" style="margin-left: 5px;">Export PDF</span></a>
				<br><br>
				<?php }?>
 					<table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <!--th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th-->
                                    <th rowspan="2" valign="top">S.No.</th>
									
                                    <th rowspan="2" valign="top">PRN</th>
                                    <th rowspan="2" valign="top">Student Name</th>
									<?php foreach($sub_list as $sb){?>
									<th colspan="2"><?=$sb['subject_code']?><BR> <?=$sb['subject_short_name']?></th>
									<?php }?>
                                    
                            </tr>
								<tr>
								<?php foreach($sub_list as $subj) {
									?>
										<th align="center">CIA</th><th align='center'>ATT</th>
								<?php } ?>
                                </tr>
                        </thead>
                        <tbody id="studtbl">
                        	<!--input type="hidden" name="semester" value="<?=$semester?>"-->
                        	<!--input type="hidden" name="school" value="<?=$school_code?>"-->
                        	<!--input type="hidden" name="stream_id" value="<?=$stream?>"-->
                            <?php
                            $CI =& get_instance();
							$CI->load->model('Marks_model');
							$examsess = explode('-', $exam);
                            //echo "<pre>";
							//print_r($stud_list);
                          if(!empty($stud_list)){
                            $j=1;                            
                            for($i=0;$i<count($stud_list);$i++)
                            {
                            	
                            ?>
	
							 
                            <tr>
                              <td><?=$j?></td>
                        		<!--input type="hidden" name="stud_prn[]" style="width:30px" value="<?=$stud_list[$i]['enrollment_no']?>"-->
                        		<!--input type="hidden" name="stud_id[]" style="width:30px" value="<?=$stud_list[$i]['stud_id']?>"-->
                                <td><?=$stud_list[$i]['enrollment_no']?></td> 
                                <td><?=strtoupper($stud_list[$i]['first_name'].' '.$stud_list[$i]['last_name']);?></td> 							
                          		<?php foreach($sub_list as $sb){
                          				$ciamrks =$this->Marks_model->fetchstudentsubCIAmarks($stud_list[$i]['stud_id'], $sb['subject_id'],$examsess[0],$examsess[1],$examsess[2]);
                          				//if(!empty($ciamrks[0]['cia_marks'])){
										
										if(!empty($ciamrks[0]['cia_id'])){
											$cia_id= $ciamrks[0]['cia_id'];
										}else{
											$cia_id=$sb['subject_id'].'~'.$stud_list[$i]['stud_id'].'~'.$stud_list[$i]['enrollment_no'].'~'.$stream.'~'.$semester.'~'.$exam_month.'~'.$exam_year.'~'.$exam_sess_id;
										}
                          			?>

										<td align='center'>
											<input type="text" name="<?=$sb['subject_id']?>_grade[]" class="verified" <?=$disabled;?> value="<?php if(!empty($ciamrks[0]['cia_marks'])){ echo $ciamrks[0]['cia_marks'];}else{ echo 0;}?>" id="<?=$cia_id?>" style="width:50px" onChange="return updateCiaMarks(this.id);" REQUIRED maxlength="3">
										</td>
											<td align='center'><?php if(!empty($ciamrks[0]['attendance_marks'])){ echo $ciamrks[0]['attendance_marks'];}else{ echo "-";}?></td>					
									
										<?php 
										unset($sb['subject_id']);
										}?>
                            </tr>
                            <?php
                            $j++;
                            }
					}else{
								echo "<tr><td colspan='3'>No data found</td></tr>";
							}
                            ?>                            
                        </tbody>
                    </table>  
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
function updateCiaMarks(resid) {
	var result_id = resid;
	var result_grade = $("#"+resid).val();
	alert(result_grade);
            if(confirm("Are you sure you want to update this Subject Marks?")){
				if (result_id !='' && result_grade !='') {
					$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Marks/updateStudSubjectCiaMarks',
						data: {result_id:result_id,cia_marks:result_grade},
						success: function (data1) {
							alert(data1);
								if(data1=='SUCCESS'){	
									//$('#alrtmsg').html('Grade Updated Successfully');
									alert('Marks Updated Successfully');
									$("#"+resid).css("background-color", "#ABEBC6");
								}
								else{
									alert("Problem while updating mark.");	
									return true;
								}
						}
					});
				} else {
					alert("Problem while updating Grade");
				}
			}

	return true;
}

</script>
