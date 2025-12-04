<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<script>    
$(document).ready(function()
{
	$('#exam_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
});

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
		var batch = $("#batch").val();
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>marks/load_prmrentrycourses',
				data: {school_code:school_code},
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
		var course_id = $(this).val();
		//alert(course_id);
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>marks/load_prmrentrystreams',
					data: {course_id:course_id},
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
				'url' : base_url + 'marks/load_prmrentrysemester',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {stream_id:stream_id},
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
			if (stream_id) {
				$.ajax({
					type: 'POST',
					'url' : base_url + 'marks/load_prmrentrysemester',
					'data' : {stream_id:stream_id},
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
				url: '<?= base_url() ?>marks/load_prmrentrystreams',
					data: {course_id:admission_course},
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
<form method="post" action ="<?=base_url()?>marks/pract_marks_entry_status">	
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Practical Marks Entry Status </h1>		  
			
		  <?php $exam_sess_val = $exam_session[0]['exam_month'] .'-'.$exam_session[0]['exam_year'].'-'.$exam_session[0]['exam_id'];?>
		  <input type="hidden" name="marks_type" id="marks_type4" value="PR">
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
							  <div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required="">
								<!--option value="">Select Exam Session</option-->
                                  <option value="<?=$exam_sess_val?>"><?=$exam_session[0]['exam_month'].'-'.$exam_session[0]['exam_year'];?></option></select>
                              </div>
							<div class="col-sm-2">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select School</option>
								 <option value="0">ALL</option>
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
                            <div class="col-sm-2" id="" >
                                <input type='text' name="exam_date" id="exam_date" class="form-control" value="<?php echo $_REQUEST['exam_date'];?>"readonly required style="display:none">
                                <input type="submit" id="" class="btn btn-primary btn-labeled pull-right1" value="Search" > 
                             </div>
                            </div>
							<!--div class="form-group">
							<div class="col-sm-12" >
                                 <input type="submit" id="" class="btn btn-primary btn-labeled pull-right" value="Search" > 
                            </div>
							 </div-->
                            </form>
                        </span>
                        <div class="holder1"></div>
                </div>

            <div class="table-info panel-body" >  

                <div class="col-lg-12">
                    <div class="table-info" id="stddata" style="<?=$tbstyle?>">    
				<?php 	
				$CI =& get_instance();
                $CI->load->model('Marks_model');
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
                                    <th>Faculty</th>
                                    <th>Ext.Faculty</th>
									<th>Date</th>
									<th>Time</th> 
									<th>Status</th>	
									<th>Download</th>
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                            <?php
							//print_r($exam);
                            //echo "<pre>";
							//print_r($sub_list);
                          if(!empty($sub_list)){
                            $j=1;   
                            $school_code='0'; 
                            $admissioncourse='0';
                            $exam1= str_replace('/','_',$exam);
                            $reval='N';
                            for($i=0;$i<count($sub_list);$i++)
                            {
                               $mrkstatus =$this->Marks_model->fetch_prexmrkstatus($sub_list[$i]['subject_id'],$sub_list[$i]['stream_id'],$sub_list[$i]['semester'],$sub_list[$i]['division'],$sub_list[$i]['batch_no'], $exam_id); 
                               $subDetails = $sub_list[$i]['subject_id'].'~'.$school_code.'~'.$admissioncourse.'~'.$sub_list[$i]['stream_id'].'~'.$sub_list[$i]['semester'].'~'.$exam1.'~'.$marks_type='PR'.'~'.$sub_list[$i]['division'].'~'.$sub_list[$i]['batch_no'].'~'.$reval.'~'.$sub_list[$i]['is_backlog'].'~'.$sub_list[$i]['exam_date'];
                            ?>
							
                            <tr>
							
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
								<td>
									<?php
										if(!empty($sub_list[$i]['fname'])){
											echo strtoupper($sub_list[$i]['fname'][0].'. '.$sub_list[$i]['mname'][0].'. '.$sub_list[$i]['lname']);
										}else{ 
											$fac_app=1;
										echo "<small style='color:red;'>Not Assigned</small>";
									}?>

								</td>
								<td>
									<?php
										if(!empty($sub_list[$i]['ext_faculty_code'])){
											echo strtoupper($sub_list[$i]['ext_faculty_code']);
										}else{ 
											$fac_app=1;
										echo "<small style='color:red;'>Not Assigned</small>";
									}?>

								</td>
								<td><?php
										if(!empty($sub_list[$i]['exam_date'])){
											echo $sub_list[$i]['exam_date'];
										}else{ 
										
										echo "<small style='color:red;'>Not Assigned</small>";
									}?></td>
								<td><?php
										if(!empty($sub_list[$i]['exam_from_time'])){
											echo $sub_list[$i]['exam_from_time'].':00 - '.$sub_list[$i]['exam_to_time'].':00 '.$sub_list[$i]['time_format'];
										}else{ 
										
										echo "<small style='color:red;'>Not Assigned</small>";
									}?>
									</td>
                                <td>
								<?php if($mrkstatus[0]['me_id'] ==''){?>
									<span style='color:red'>Not Entered</span>
								<?php }else{ ?>
									<span style='color:green'>Entered</span>
								<?php }?>
                                </td>						
                                <td>
									<?php
									//print_r($mrkstatus);
									if($mrkstatus[0]['me_id'] !='') {	 
									?>
                                    <a href="<?=base_url($currentModule."/downldPractmarkspdf/".base64_encode($subDetails).'/'.base64_encode($mrkstatus[0]['me_id']))?>" traget="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i></a>
									<?php } ?>
								</td>
                            </tr>
                            <?php
                            $j++;
                            }
						  }else{
							  echo "<tr><td colspan=12> No data found.</td></tr>";
						  }
                            ?>                            
                        </tbody>
                    </table>  
				
                </div>
                </div>
				
				
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>