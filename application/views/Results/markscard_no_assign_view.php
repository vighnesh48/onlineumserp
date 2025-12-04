<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>

<script>    
$(document).ready(function(){
		$('#exam_session').on('change', function () {	
		var exam_session = $(this).val();
		//alert(exam_session);
		if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsess_schools',
				data: 'exam_session=' + exam_session,
				success: function (html) {
					//alert(html);
					$('#school_code').html(html);
				}
			});
		} else {
			$('#school_code').html('<option value="">Select exam session first</option>');
		}
	}); 
//
	var exam_session = '<?=$exam?>';
		//alert(exam_session);
		if (exam_session) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examsess_schools',
				data: 'exam_session=' + exam_session,
				success: function (html) {
					var schoolcode = '<?=$school_code?>';
					$('#school_code').html(html);
					$("#school_code option[value='" + schoolcode + "']").attr("selected", "selected");
				}
			});
		} else {
			$('#school_code').html('<option value="">Select exam session first</option>');
		}
		
	$('#school_code').on('change', function () {	
		var school_code = $(this).val();
		var exam_session = $('#exam_session').val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_schools',
				data: {school_code:school_code,exam_session:exam_session},
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
				data: {school_code:school_code,exam_session:exam_session},
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
		var exam_session = $("#exam_session").val();
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Results/load_resultstreams',
				data: {course_id:admission_course,exam_session:exam_session},
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
					url: '<?= base_url() ?>Results/load_edsemesters_marksheets',
					data: {stream_id:stream_id,ex_ses:exam_session},
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
		var exam_session = $("#exam_session").val();
			if (stream_id1) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Results/load_edsemesters_marksheets',
					data: {stream_id:stream_id1,ex_ses:exam_session},
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
				url: '<?= base_url() ?>Results/load_resultstreams',
				data: {course_id:admission_course,exam_session:exam_session},
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
		$('.numbersOnly').keyup(function () {
			if (this.value != this.value.replace(/[^A-B0-9\.]/g, '')) {
			   this.value = this.value.replace(/[^A-B0-9\.]/g, '');
			}
		});		
});
</script>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Examination</a></li>
        <li class="active"><a href="#">Results</a></li>
    </ul>
    <div class="page-header">
    	<div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Gradesheet-No  Assign</h1>
            <div class="col-xs-12 col-sm-8">
                
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
                            <form method="post" action ="<?=base_url()?>Results/markscardno">	
                            <div class="form-group">
							 <div class="col-sm-2" >
                                <select name="regulation" id="regulation" class="form-control" required>
                                  <option value="">Select Regulation</option>
                                  <?php
                                    foreach ($regulatn as $reg) {
                                        if ($reg['regulation'] == $regulation) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $reg['regulation'] . '"' . $sel . '>' . $reg['regulation'] . '</option>';
                                    }
                                    ?>
                               </select>
                              </div>
							 <div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required>
                                 <option value="">Exam Session</option>
                                  <?php

									foreach ($exam_session as $exsession) {
										$exam_sess = $exsession['exam_month'].'-'.$exsession['exam_year'].'-'.$exsession['exam_id'];
									    if ($exam_sess == $exam) {
									        $sel = "selected";
									    } else {
									        $sel = '';
									    }
									    echo '<option value="' . $exam_sess. '"' . $sel . '>' .$exsession['exam_month'].'-'.$exsession['exam_year'].'-'.$exsession['exam_type'].'</option>';
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

                              <div class="col-sm-2" id="semest">
                                <select name="admission-branch" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
                              <div class="col-sm-2" id="">
                                <select name="semester" id="semester" class="form-control" required>
                                  <option value="">Select Semester</option>
                                   <!--option value="1" <?php if($_REQUEST['semester'] ==1){ echo "selected";}else{}?>>1 </option>
                                   <option value="2" <?php if($_REQUEST['semester'] ==2){ echo "selected";}else{}?>>2 </option>
                                   <option value="3" <?php if($_REQUEST['semester'] ==3){ echo "selected";}else{}?>>3 </option>
                                   <option value="4" <?php if($_REQUEST['semester'] ==4){ echo "selected";}else{}?>>4 </option-->
                                  </select>
                             </div>
							 <div class="col-sm-2" id="">
                                <select name="scheme" id="scheme" class="form-control" required>
                                  <option value="">Select Scheme</option>
                                   <option value="new" <?php if($_REQUEST['scheme'] =='new'){ echo "selected";}else{}?>>New </option>
                                   <option value="old" <?php if($_REQUEST['scheme'] =='old'){ echo "selected";}else{}?>>Old </option>
                            
                                  </select>
                             </div>
							 <br><br>
                              <div class="col-sm-2 pull-right" id="semest">
                                 <input type="submit" id="" class="btn btn-primary btn-labeled pull-right" value="Search" > 
                            </div>
                            </div>
                            </form>
                        </span>
                        <div class="holder1"></div>
                </div>
			
            <div class="table-info panel-body" style="width:100%;">  
			<?php 
			$role_id=$this->session->userdata('role_id');
			//if(isset($role_id) && $role_id==1 ){?>
          

            
				<?php// }?>
			
                <div class="col-lg-12">
				<div class="row" style="color:green;margin-left:15px;margin-bottom:5px;">
               		 <b><?php if(!empty($this->session->flashdata('mskrd'))){ echo $this->session->flashdata('mskrd');}?>  </b>                  
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
                    <div class="table-info table-responsive" id="stddata" >    
				<?php 	
					if(!empty($stud_list)){
				
				?>
				<form name="mrkcrdfrom" id="mrkcrdfrom" method="post" action="<?=base_url()?>Results/insert_markscard_data">
 					<table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <th class="noExl"></th>
                                    <th>S.No.</th>									
                                    <th>PRN</th>
                                    <th>Student Name</th>
									<th>Semester</th>
									<th>Markscard No</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        	<input type="hidden" name="regulation" id="regulation" value="<?=$regulation?>">
                        	<input type="hidden" name="semester" id="ressemester" value="<?=$semester?>">
                        	<input type="hidden" name="school" value="<?=$school_code?>">
                        	<input type="hidden" name="course" id="regulation" value="<?=$admissioncourse?>">
                        	<input type="hidden" name="stream_id" id='resstream_id' value="<?=$stream?>">
                        	<input type="hidden" name="exam_session" id="resexam_session" value="<?=$exam_month.'-'.$exam_year.'-'.$exam_id?>">
                            <?php
							$CI =& get_instance();
						    $CI->load->model('Results_model');
							$exam_month = str_replace('/','_',$exam_month);
							$result_data = $stream.'~'.$semester.'~'.$exam_month.'~'.$exam_year.'~'.$exam_id;
							// echo '<pre>';
							// print_r($stud_list);exit;
                             $j=1;                        
                            for($i=0;$i<count($stud_list);$i++)
                            {
                            	$ce_earnd = $this->Results_model->fetch_student_ce_earnd_semester($stud_list[$i]['student_id'],$semester,$exam_id);
								
								
								// $ce_registerd = $this->Results_model->fetch_student_ce_registerd_semester($stud_list[$i]['stud_id'],$semester);
								
								$ce_applied = $this->Results_model->fetch_student_applied_ce_semester($stud_list[$i]['student_id'],$semester,$stream);
								
								echo $stud_list[$i]['enrollment_no'].'->';    
								print_r($ce_earnd->credit_earned); 
								print_r($ce_applied->credits_registered); echo '/   /';

								// if($ce_applied->credits_registered == $ce_earnd->credit_earned){
								  
								if($stud_list[$i]['admission_session'] >=2023 && $stud_list[$i]['lateral_entry']=='N'){ 
								if($ce_applied->credits_registered == $ce_earnd->credit_earned){
									   
                            ?>
	
							 <input type="hidden" id="res_data" name="res_data" value="<?=$result_data?>">
                            <tr>
							<td class="noExl"><input type="checkbox" name="chk_stud[]" id="chk_stud_<?=$j?>" class='studCheckBox' value="<?=$stud_list[$i]['student_id']?>" disabled></td>
                              <td><?=$j?></td>
                        		<input type="hidden" name="stud_prn[]" id="prn_<?=$j?>" style="width:30px" value="<?=$stud_list[$i]['enrollment_no']?>" disabled>
                        		<!--input type="hidden" name="stud_id[]" style="width:30px" value="<?=$stud_list[$i]['student_id']?>"-->
                                <td><?=$stud_list[$i]['enrollment_no']?></td> 
                                <td><?=$stud_list[$i]['stud_name'];?></td> 	
								<td><?=$stud_list[$i]['semester'];?></td> 	
								<td><input type="text" id="mrk_<?=$j?>" name="markscardno[]" value="<?=$stud_list[$i]['markscard_no']?>" class="form-control" style="width: 100px;" disabled></td>								
                            </tr>
                            <?php
							$j=$j+1;
								}
								
								}else{ 
								
								//echo 1;exit;?>
									 <input type="hidden" id="res_data" name="res_data" value="<?=$result_data?>">
                            <tr>
							<td class="noExl"><input type="checkbox" name="chk_stud[]" id="chk_stud_<?=$j?>" class='studCheckBox' value="<?=$stud_list[$i]['student_id']?>" disabled></td>
                              <td><?=$j?></td>
                        		<input type="hidden" name="stud_prn[]" id="prn_<?=$j?>" style="width:30px" value="<?=$stud_list[$i]['enrollment_no']?>" disabled>
                        		<!--input type="hidden" name="stud_id[]" style="width:30px" value="<?=$stud_list[$i]['student_id']?>"-->
                                <td><?=$stud_list[$i]['enrollment_no']?></td> 
                                <td><?=$stud_list[$i]['stud_name'];?></td> 	
								<td><?=$stud_list[$i]['semester'];?></td> 	
								<td><input type="text" id="mrk_<?=$j?>" name="markscardno[]" value="<?=$stud_list[$i]['markscard_no']?>" class="form-control" style="width: 100px;" disabled></td>								
                            </tr>
								<?php 
								$j=$j+1;
								}
                            
                            }
                            ?>                            
                        </tbody>
                    </table>  
                    <ul class="nav nav-tabs">
					<li class="active"><a data-toggle="tab" href="#menu1">Assign MarksCard No </a></li>
					<li><a data-toggle="tab" href="#menu2">Dispatch Report</a></li>
					<li><a data-toggle="tab" href="#menu3">Ladger Report</a></li>
				  </ul>
                   <div class="tab-content">
						<div id="menu1" class="tab-pane fade in active">	 
						  <p><table class="table table-bordered">
                    	<tr>
                    		<td>From S.No </td>
                    		<td><input type="text" name="frmserno" id="frmserno" maxlength="3" class="numbersOnly"></td>
                    		<td>TO S.No </td>
                    		<td><input type="text" name="toserno" id="toserno" maxlength="3" class="numbersOnly"></td>
                    	</tr>
                    	<tr>
                    		<td>Marks Card No Start From </td>
                    		<td><input type="text" name="mrkcrdno" id="mrkcrdno" maxlength="7" class="numbersOnly"></td>
                    		
                    		<td colspan=2><input type="button" name="assign" id="assignmcn" class="btn btn-primary" value="Assign">&nbsp;&nbsp;
                    			<input type="submit" name="generate" value="Save Markscard" id="gmarkscard1" class="btn btn-primary" onclick="return validate_student(this.value)">
						
                    		</td>
                    	</tr>
                    </table></p>
						</div>
						<div id="menu2" class="tab-pane fade">
						 
						  <p><input type="button" name="assign" id="emdsexcl" class="btn btn-primary" value="Download PDF"></p>
						</div>
						<div id="menu3" class="tab-pane fade">
						  <p> Coming soon.<!--input type="button" name="assign" id="emlsexcl" class="btn btn-primary" value="Download Lazar Report"--></p>
						</div>
				  </div> 
                    </form>
                     <?php } ?>
                </div>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>

<style>    
input{text-transform:uppercase};
</style> 
<script type="text/javascript">
	function checkgrade(id){

		var result_grade = $("#"+id).val().toUpperCase();
		var grade_letter1 = '<?=$grade_letters?>';
		var grade_letter2 = grade_letter1.slice(0, -1);
		var grade_letter3 = grade_letter2.split(',');

		if (jQuery.inArray(result_grade, grade_letter3)!='-1') {
            //alert(result_grade + ' is in the array!');
        } else {
            alert(result_grade + ' is NOT the Grade letter');
            $("#"+id).val('');
            $("#"+id).focus();
            return false;
        }
	}
function validate_student(strm){

	var chk_stud_checked_length = $('input[class=studCheckBox]:checked').length;
	if(chk_stud_checked_length == 0){
		 alert('please check atleast one Student from student list');
		 return false;
	}else{
		return true;
	}
} 	
$(document).ready(function () {
	$('#chk_stud_all').change(function () {
        $('.studCheckBox').prop('checked', $(this).prop('checked'));
    });
	
		//Allocate batch
	$('#assignmcn').on('click', function () {
		//alert("hi");
			var frmserno = $("#frmserno").val();
			var toserno = $("#toserno").val();
			var mrkcrd_no = $("#mrkcrdno").val();
			var range_cnt = toserno - frmserno;
			//alert(range_cnt);
			if(frmserno !='' && toserno !='' && mrkcrd_no !=''){
			for (var i = 0; i <= range_cnt; i++) {
				//alert("value="+mrkcrd_no);
				$('#mrk_'+frmserno).val(mrkcrd_no);
				$('#chk_stud_'+frmserno).prop("disabled", false);
				$('#mrk_'+frmserno).prop("disabled", false);
				$('#prn_'+frmserno).prop("disabled", false);
				$('#chk_stud_'+frmserno).prop("checked", 'checked');
				frmserno++;
				
				var cnt_l = parseInt(mrkcrd_no.length);
				//alert("l==="+cnt_l);
				mrkcrd_no++;
				mrkcrd_no =(parseInt(mrkcrd_no)).pad(cnt_l);

			}
			alert("Markscard no assigned successfully.");
		}else{
			alert("Please enter all input fields.");
		}
		
	});
	//dispatch report
		$('#emdsexcl').on('click', function () {	
		var res_data = $("#res_data").val();
		if (res_data) {
			window.location.href = '<?= base_url() ?>Results/download_mrksno_dispatch_report/'+res_data;
		} else {
			
		}
	});
	//lazar report
		$('#emlsexcl').on('click', function () {	
		var res_data = $("#res_data").val();
		if (res_data) {
			window.location.href = '<?= base_url() ?>Results/lazar_report/'+res_data;
		} else {
			
		}
	});	

});	
Number.prototype.pad = function(size) {
  var s = String(this);
  while (s.length < (size || 2)) {s = "0" + s;}
  return s;
}
</script>