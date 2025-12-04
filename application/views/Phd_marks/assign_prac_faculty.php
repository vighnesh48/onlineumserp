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
				url: '<?= base_url() ?>Phd_examination/load_schools',
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
				url: '<?= base_url() ?>Phd_examination/load_schools',
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
		var course_id = $(this).val();
			var batch = $("#batch").val();

			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Phd_examination/load_streams',
					data: {course_id:course_id,batch:batch},
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
		var stream_id = $("#stream_id").val();
		var batch = $("#batch").val();

		if (stream_id) {
			$.ajax({
				'url' :'<?= base_url() ?>Subject/load_semester',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {batch: batch,stream_id:stream_id},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#semester'); //jquery selector (get element by id)
					if(data){	
						container.html(data);
					}
				}
			});
		} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		});
		//edit semester
		var stream_id = '<?=$stream?>';
		var batch = '<?=$batch?>';
			if (stream_id) {
				$.ajax({
					type: 'POST',
					'url' : base_url + '/Subject/load_semester',
					'data' : {'batch' : batch,stream_id:stream_id},
					success: function (html) {
						//alert(html);
						var semester = '<?=$semester?>';
						$('#semester').html(html);
						$("#semester option[value='" + semester + "']").attr("selected", "selected");
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
				url: '<?= base_url() ?>subject/load_streams',
					data: {course_id:admission_course,batch:batch},
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
<form method="post" action ="<?=base_url()?>Phd_marks/assign_prac_faculty">	
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Practical Faculty Assign </h1>
			<div style="padding-top:5px;">Exam Session : <?=$exam_session[0]['exam_month'].'-'.$exam_session[0]['exam_year'];?>, &nbsp;&nbsp;&nbsp;&nbsp; Subject Type: &nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="marks_type" id="marks_type3" value="PR" checked="true" required> Practical   
			
		  <?php $exam_sess_val = $exam_session[0]['exam_month'] .'-'.$exam_session[0]['exam_year'].'-'.$exam_session[0]['exam_id'];?>
		  <input type="hidden" name="exam_session" id="exam_session" value="<?=$exam_sess_val?>">
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
                            
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							  <div class="col-sm-2" >
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
									foreach ($academic_year as $yr) {
										if ($yr['academic_year'].'~'.$yr['academic_session'] == $academicyear) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session'].'"' . $sel . '>' . $yr['academic_year'].' ('.$yr['academic_session'] . ')</option>';
									}
									?>
									 <option value="2019-20~WINTER" selected="">2019-20 (WINTER)</option>
                               </select>
                              </div>
							  <div class="col-sm-2" >
                                <select name="batch" id="batch" class="form-control" required>
                                  <option value="">Select Batch</option>
                                  <?php
                                    foreach ($batches as $bth) {
                                        if ($bth['batch'] == $batch) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $bth['batch'] . '"' . $sel . '>' . $bth['batch'] . '</option>';
                                    }
                                    ?>
                               </select>
                              </div>
							<div class="col-sm-2">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select School</option>
                                  <?php
foreach ($schools as $sch) {
    if ($sch['school_code'] == $school_code) {
        $sel1 = "selected";
    } else {
        $sel1 = '';
    }
    echo '<option value="' . $sch['school_code'] . '"' . $sel1 . '>' . $sch['school_short_name'] . '</option>';
}
?></select>
                              </div>
                              <div class="col-sm-2">
                                <select name="admission-course" id="admission-course" class="form-control" required>
                                 <option value="">Select Course</option>
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
                            
                            </div>
							<div class="form-group">
							<div class="col-sm-12" >
                                 <input type="submit" id="" class="btn btn-primary btn-labeled pull-right" value="Search" > 
                            </div>
							 </div>
                            </form>
                        </span>
                        <div class="holder1"></div>
                </div>

            <div class="table-info panel-body" >  
			<?php 
			$role_id=$this->session->userdata('role_id');
			//if(isset($role_id) && $role_id==1 ){?>
            <form id="" method="post" action ="<?=base_url()?>Exam_timetable/insert_exam_timetable">

            <input type="hidden" name="stream_id" value="<?=$stream?>">
			<input type="hidden" name="adm_semester" value="<?=$semester?>">
				<?php// }?>
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" style="<?=$tbstyle?>">    
				<?php 	
					if($_POST){
				$CI =& get_instance();
                $CI->load->model('Phd_marks_model');
				?>
			
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   
                                    <th>S.No.</th>
									
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
									<th>Semester</th>
									<th>Division</th>
									<th>Batch</th>
									<th>Strength</th>
                                    <th>Faculty</th>
                                    <th>Ext.Faculty</th>
									<th>Date</th>
									<th>Time</th>
                                    <th width="10%">Action</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                            <?php
                           
                          if(!empty($sub_list)){
                            $j=1;                            
                            for($i=0;$i<count($sub_list);$i++)
                            {
								
								
								
								
                               $studstrength =$this->Phd_marks_model->fetch_student_strengthdata($sub_list[$i]['sub_id'],$sub_list[$i]['tt_details'][0]['stream_id'],$sub_list[$i]['semester'],$sub_list[$i]['division'],$sub_list[$i]['batch_no'], $academicyear); 
                            ?>
							<input type="hidden" name="subject_id[]" id="subject_id<?=$j?>" class='studCheckBox' value="<?=$sub_list[$i]['sub_id']?>">
							<input type="hidden" name="subject_code[]" id="subject_code<?=$j?>" class='studCheckBox' value="<?=$sub_list[$i]['subject_code']?>">
							 <?php if($sub_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$sub_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
							
                              <td><?=$j?></td>
                        
                                 <td><?=strtoupper($sub_list[$i]['subject_code'])?></td> 
                                    <td>
							
							<?php
								echo strtoupper($sub_list[$i]['subject_name']);
								?>
								</td> 
								<td><?=$sub_list[$i]['semester']?></td>
								<td><?=$sub_list[$i]['division']?></td>
								<td><?=$sub_list[$i]['batch_no']?></td>
								<td><?=   count($studstrength);?></td>
									<td>
									<?php
										if(!empty($sub_list[$i]['tt_details'][0]['fname'])){
											echo strtoupper($sub_list[$i]['tt_details'][0]['fname'][0].'. '.$sub_list[$i]['tt_details'][0]['mname'][0].'. '.$sub_list[$i]['tt_details'][0]['lname']);
										}else{ 
											$fac_app=1;
										echo "<small style='color:red;'>Not Assigned</small>";
									}?>

								</td>
								<td>
									<?php
										if(!empty($sub_list[$i]['tt_details'][0]['ext_faculty_code'])){
											echo strtoupper($sub_list[$i]['tt_details'][0]['ext_faculty_code']);
										}else{ 
											$fac_app=1;
										echo "<small style='color:red;'>Not Assigned</small>";
									}?>

								</td>
								<td><?php
										if(!empty($sub_list[$i]['tt_details'][0]['exam_date'])){
											echo $sub_list[$i]['tt_details'][0]['exam_date'];
										}else{ 
										
										echo "<small style='color:red;'>Not Assigned</small>";
									}?></td>
								<td><?php
										if(!empty($sub_list[$i]['tt_details'][0]['exam_from_time'])){
											echo $sub_list[$i]['tt_details'][0]['exam_from_time'].':00 - '.$sub_list[$i]['tt_details'][0]['exam_to_time'].':00 '.$sub_list[$i]['tt_details'][0]['time_format'];
										}else{ 
										
										echo "<small style='color:red;'>Not Assigned</small>";
									}?></td>
                                <td>
                                	<a href="<?=base_url($currentModule."/add_subject_faculty/".$sub_list[$i]['sub_id'].'/'.$sub_list[$i]['stream_id'].'/'.$sub_list[$i]['semester'].'/'.$exam_id.'/'.$school_code.'/'.$sub_list[$i]['division'].'/'.$sub_list[$i]['batch_no'])?>" target="_blank">
									<i class="fa fa-edit"></i></a> 
									
									<!--|| 
									<a href="<?=base_url($currentModule."/faculty_subject/".$sub_list[$i]['sub_id'].'/'.$sub_list[$i]['stream_id'].'/'.$sub_list[$i]['semester'].'/'.$exam_id.'/'.$school_code.'/'.$sub_list[$i]['division'].'/'.$sub_list[$i]['batch_no'])?>" target="_blank">
									<i class="fa fa-plus"></i></a>-->
                                </td>						
                          
                            </tr>
                            <?php
                            $j++;
                            }
						  }else{
							  echo "<tr><td colspan=9> No data found.</td></tr>";
						  }
                            ?>                            
                        </tbody>
                    </table>  
					<div><h5><b>Back Log Subjects:</b></h5></div>
				<table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   
                                    <th>S.No.</th>
									
                                    <th>Subject Code</th>
                                    <th>Subject Name</th>
									<th>Semester</th>
									<th>Division</th>
									<th>Batch</th>
									<th>Strength</th>
                                    <th>Faculty</th>
									<th>Ext.Faculty</th>
									<th>Date</th>
									<th>Time</th>									
                                    <th width="10%">Action</th>
                                    
                            </tr>
                        </thead>
                       <tbody id="studtbl">
                            <?php
                            //echo "<pre>";
							//print_r($bksub_list);
                          if(!empty($bksub_list)){
                            $j=1;                            
                            for($i=0;$i<count($bksub_list);$i++)
                            {
                               //echo $bksub_list[$i]['isPresent']; 
							   $bk_studstrength =$this->Phd_marks_model->fetch_student_strength_backlog($bksub_list[$i]['sub_id'],$bksub_list[$i]['semester']);
                            ?>
							<input type="hidden" name="subject_id[]" id="subject_id<?=$j?>" class='studCheckBox' value="<?=$bksub_list[$i]['sub_id']?>">
							<input type="hidden" name="subject_code[]" id="subject_code<?=$j?>" class='studCheckBox' value="<?=$bksub_list[$i]['subject_code']?>">
							 <?php if($bksub_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$bksub_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
							
                              <td><?=$j?></td>
                        
                                 <td><?=strtoupper($bksub_list[$i]['subject_code'])?></td> 
                                    <td>
							
							<?php
								echo strtoupper($bksub_list[$i]['subject_name']);
								?>
								</td> 
								<td><?=$bksub_list[$i]['semester']?></td>
								<td>A</td>
								<td>1</td>
								<td><?=$bk_studstrength[0]['cnt']?></td>
								<td>
									<?php
										if(!empty($bksub_list[$i]['tt_details'][0]['fname'])){
											echo strtoupper($bksub_list[$i]['tt_details'][0]['fname'][0].'. '.$bksub_list[$i]['tt_details'][0]['mname'][0].'. '.$bksub_list[$i]['tt_details'][0]['lname']);
										}else{ 
											$fac_app=1;
										echo "<small style='color:red;'>Not Assigned</small>";
									}?>

								</td>
								<td>
									<?php
										if(!empty($bksub_list[$i]['tt_details'][0]['ext_faculty_code'])){
											echo strtoupper($bksub_list[$i]['tt_details'][0]['ext_faculty_code']);
										}else{ 
											$fac_app=1;
										echo "<small style='color:red;'>Not Assigned</small>";
									}?>

								</td>
								<td><?php
										if(!empty($bksub_list[$i]['tt_details'][0]['exam_date'])){
											echo $bksub_list[$i]['tt_details'][0]['exam_date'];
										}else{ 
										
										echo "<small style='color:red;'>Not Assigned</small>";
									}?></td>
								<td><?php
										if(!empty($bksub_list[$i]['tt_details'][0]['exam_from_time'])){
											echo $bksub_list[$i]['tt_details'][0]['exam_from_time'].':00 - '.$bksub_list[$i]['tt_details'][0]['exam_to_time'].':00 '.$bksub_list[$i]['tt_details'][0]['time_format'];
										}else{ 
										
										echo "<small style='color:red;'>Not Assigned</small>";
									}?></td>
                                <td>
                                	<a href="<?=base_url($currentModule."/add_subject_faculty/".$bksub_list[$i]['subject_id'].'/'.$bksub_list[$i]['stream_id'].'/'.$bksub_list[$i]['semester'].'/'.$exam_id.'/'.$school_code.'/A/1/bklog/')?>" target="_blank">
									<i class="fa fa-edit"></i></a>
                                </td>						
                          
                            </tr>
                            <?php
                            $j++;
                            }
						  }else{
							  echo "<tr><td colspan=9> No data found.</td></tr>";
						  }
                            ?>                            
                        </tbody>
                    </table>  
					
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

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">


<script>
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
});	

$(document).ready(function() {
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
   filename: "Student List" //do not include extension

  });

});
   // $('#example').DataTable( {
    //    dom: 'Bfrtip',
    //    buttons: [
     //       'csv', 'excel'
       // ]
    //} );
} );
</script>