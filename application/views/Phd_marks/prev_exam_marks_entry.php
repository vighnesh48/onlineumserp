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
		var exam_session = $("#exam_session").val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examschools',
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
var exam_session = $("#exam_session").val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examschools',
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
		//alert(exam_session);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_examstreams',
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
					url: '<?= base_url() ?>Examination/load_examsemesters',
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
		var exam_session = $("#exam_session").val();
			if (stream_id1) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Examination/load_examsemesters',
					data: {stream_id:stream_id1,exam_session:exam_session},
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
    	<div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Examination Grades</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row" style="color:green">
               		 <?php if(!empty($this->session->flashdata('msg'))){ echo $this->session->flashdata('msg');}?>                    
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
                            <form method="post" action ="<?=base_url()?>marks/exam_grade_entry">	
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							 <div class="col-sm-1" >
                                <select name="regulation" id="regulation" class="form-control" required>
                                  <option value="">Select Regulation</option>
                                  <?php
                                    foreach ($regulatn as $reg) {
                                        if ($reg['regulation'] == $_REQUEST['regulation']) {
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
								<!--option value="MAR-2018">MAR-2018</option-->
                                  <?php

									foreach ($exam_session as $exsession) {
										$exam_sess = $exsession['exam_month'].'-'.$exsession['exam_year'].'-'.$exsession['exam_id'].'-'.$exsession['academic_year'];
									    if ($exam_sess == $_REQUEST['exam_session']) {
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
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-2" id="semest">
                                <select name="admission-branch" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                                  </select>
                              </div>
                              <div class="col-sm-1" id="">
                                <select name="semester" id="semester" class="form-control" required>
                                  <option value="">Select Semester</option>
								  <option value="0">All Courses</option>
                                   <!--option value="1" <?php if($_REQUEST['semester'] ==1){ echo "selected";}else{}?>>1 </option>
                                   <option value="2" <?php if($_REQUEST['semester'] ==2){ echo "selected";}else{}?>>2 </option>
                                   <option value="3" <?php if($_REQUEST['semester'] ==3){ echo "selected";}else{}?>>3 </option>
                                   <option value="4" <?php if($_REQUEST['semester'] ==4){ echo "selected";}else{}?>>4 </option-->
                                  </select>
                             </div>
							 <div class="col-sm-2" id="semest">
                                <select name="grade_updtype" id="grade_updtype" class="form-control" required>
                                  <option value="">Select type</option>
								  <option value="Regular" <?php if($_REQUEST['grade_updtype'] =='Regular'){ echo "selected";}else{}?>>Regular</option>
								  <option value="Malpractice" <?php if($_REQUEST['grade_updtype'] =='Malpractice'){ echo "selected";}else{}?>>Malpractice</option>
								  <!--option value="Revaluation" <?php if($_REQUEST['grade_updtype'] =='Revaluation'){ echo "selected";}else{}?>>Revaluation</option-->
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
                             </div--><br><br>
                              <div class="col-sm-2 pull-right" id="semest">
                                 <input type="submit" id="" class="btn btn-primary btn-labeled pull-right" value="Search" > 
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
			<?php 
			$role_id=$this->session->userdata('role_id');
			//if(isset($role_id) && $role_id==1 ){?>
          

            
				<?php// }?>
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" style="overflow-x:scroll;height:500px; overflow-y:scroll;width:100%;">    
				<?php 	
					if($_POST){
				
				?>
					<form name="mrkentry" method="post" action ="<?=base_url()?>marks/insert_prev_exam_marks">
 					<table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <!--th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th-->
                                    <th>S.No.</th>
									
                                    <th>PRN</th>
                                    <th>Student Name</th>
									<?php foreach($sub_list as $sb){?>
									<th><?=$sb['subject_code']?><BR> <?=$sb['subject_short_name']?>
										<!-- <table class="table-bordered" ><tr>
										<td width="40">INT</td><td width="40">EXT</td><td width="40">TOT</td><td >GRADE</td>
									</tr></table> -->
									</th>
									<?php }?>
                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        	<input type="hidden" name="semester" value="<?=$semester?>">
                        	<input type="hidden" name="school" value="<?=$school_code?>">
                        	<input type="hidden" name="stream_id" value="<?=$stream?>">
                        	<input type="hidden" name="examdetails" value="<?=$exsession['exam_month'].'~'.$exsession['exam_year'].'~'.$exsession['exam_id']?>">
                            <?php
                            //echo "<pre>";
							//print_r($stud_list);
                          if(!empty($stud_list)){
                            $j=1;                            
                            for($i=0;$i<count($stud_list);$i++)
                            {
                               //echo $stud_list[$i]['isPresent']; 
                            ?>
	
							 
                            <tr>
                              <td><?=$j?></td>
                        		<input type="hidden" name="stud_prn[]" style="width:30px" value="<?=$stud_list[$i]['enrollment_no']?>">
                        		<input type="hidden" name="stud_id[]" style="width:30px" value="<?=$stud_list[$i]['stud_id']?>">
                                <td><?=$stud_list[$i]['enrollment_no']?></td> 
                                <td><?=strtoupper($stud_list[$i]['first_name'].' '.$stud_list[$i]['last_name']);?></td> 							
                          		<?php foreach($sub_list as $sb){?>
									<td><table class="table-bordered"><tr>
										<!-- <td width="40"><input type="text" name="<?=$sb['sub_id']?>_int[]" style="width:30px"></td>
										<td width="40"><input type="text" name="<?=$sb['sub_id']?>_ext[]" style="width:30px" ></td>
										<td width="40"><input type="text" name="<?=$sb['sub_id']?>_tot[]" style="width:30px" ></td> -->
										<td ><input type="text" name="<?=$sb['sub_id']?>_grade[]" id="<?=$stud_list[$i]['stud_id'].'_'.$sb['sub_id']?>" style="width:50px" maxlength="3" onChange="return checkgrade(this.id)" REQUIRED>
											<!-- <input type="hidden" name="subid[]" style="width:30px" value="<?=$sb['sub_id']?>"> -->
										</td>
									</tr></table></td>
									<?php }?>
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
                    <input type="submit" name="submit" value="Submit" class="btn btn-primary">
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
</script>