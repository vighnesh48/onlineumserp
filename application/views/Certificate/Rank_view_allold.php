<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css">
<script src="<?php echo base_url('assets/javascripts').'/bootstrap-datepicker.js' ?> "></script>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>

<script>    
$(document).ready(function()
{
	$('#mrk_cer_date').datepicker( {format: 'dd/mm/yyyy',autoclose: true});
});

function getExamDate(id){
	$('#'+id).datepicker( {format: 'dd/mm/yyyy',autoclose: true});
	$('#'+id).focus();
	return true;
}
    var base_url = '<?=base_url();?>';
	
	function load_streams(type){
                   // alert(type);
       var ex_ses = $("#exam_session").val();             
		$.ajax({
			'url' : base_url + '/Certificate/load_edstreams_for_rank',
			'type' : 'POST', //the way you want to send data to your URL
			'data' : {'course' : type,ex_ses:ex_ses},
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
		var ex_ses = $("#exam_session").val();
		//schoolname =$("#school_code option:selected" ).text();
		$("#schoolname").val($("#school_code option:selected" ).text());
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/load_edschools',
				data: {school_code:school_code,ex_ses:ex_ses},
				success: function (html) {
					//alert(html);
					$('#admission_course').html(html);
				}
			});
		} else {
			$('#admission_course').html('<option value="">Select course first</option>');
		}
	});  
// edit
var school_code = '<?=$school_code?>';

		if (school_code) {
			var ex_ses = $("#exam_session").val(); 
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/load_edschools',
				data: {school_code:school_code,ex_ses:ex_ses},
				success: function (html) {
					//alert(html);
					var course_id = '<?=$admissioncourse?>';
					$('#admission_course').html(html);
					$("#admission_course option[value='" + course_id + "']").attr("selected", "selected");
				}
			});
		} else {
			
			$('#admission_course').html('<option value="">Select course first</option>');
		}	
		//load streams
		$('#admission_course').on('change', function () {	
		
		var admission_course = $("#admission_course").val();
		var ex_ses = $("#exam_session").val(); 
		var school_code = $("#school_code").val(); 
		$("#admissioncourse").val($("#admission_course option:selected" ).text());
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/load_edstreams_for_rank',
				data: {course_id:admission_course,ex_ses:ex_ses,school_code:school_code},
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
			var ex_ses = $("#exam_session").val();    
			$("#admissionbranch").val($("#stream_id option:selected" ).text());  
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Certificate/load_edsemesters',
					data: {stream_id:stream_id,ex_ses:ex_ses},
					success: function (newdata) {
						//alert(html);
						
						$('#semester').val(newdata);
						$('#ressemester').val(newdata);
					}
				});
			} else {
				$('#semester').val('');
				$('#ressemester').val('');
			}
		});
		
		var stream_id1 = '<?=$stream?>';
			if (stream_id1) {
				var ex_ses = $("#exam_session").val();   
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Certificate/load_edsemesters',
					data: {stream_id:stream_id1,ex_ses:ex_ses},
					success: function (html_nt) {
						//alert(html);
						//var semester1 = '<?=$semester?>';
						$('#semester').val(html_nt);
						$('#ressemester').val(html_nt);
						//$("#semester option[value='" + semester1 + "']").attr("selected", "selected");
					}
				});
			} else {
				//$('#semester').html('<option value="">Select Stream first</option>');
				        $('#semester').val('');
						$('#ressemester').val('');
			}
	// edit
var admission_course = '<?=$admissioncourse?>';

		if (admission_course) {
		var admission_branch ='<?=$stream?>';
		var ex_ses = $("#exam_session").val(); 
		var school_code = '<?=$school_code?>'; 
		$("#admissioncourse").val($("#admission_course option:selected" ).text());
		//alert(admission_course);
		//if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Certificate/load_edstreams_for_rank',
				data: {course_id:admission_course,ex_ses:ex_ses,school_code:school_code,admission_branch:admission_branch},
				success: function (html) {
					//alert(html);
					$('#stream_id').html(html);
				}
			});
		} else {
			
			//$('#stream_id').html('<option value="">Select course first</option>');
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
        <li class="active"><a href="#">Results</a></li>
    </ul>
    <div class="page-header">
    	<div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Rank Generation For All</h1>
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
                            <form method="post" action ="<?=base_url()?>Certificate/Rank_Certificate_all">	
                            <div class="form-group">
							 <div class="col-sm-2" >
                                <select name="regulation" id="regulation" class="form-control" required>
                                  <option value="">Select Admission Session</option>
                                  <?php

                                  //print_r($regulatn);exit;
                                    foreach ($regulatn as $reg) {
                                    	//echo $reg;exit;

										if($reg['regulation']=='2016'){}else{
                                        if ($reg['regulation'] == $_REQUEST['regulation']) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $reg['regulation'] . '"' . $sel . '>' . $reg['regulation'] . '</option>';
                                    }
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
                                 <option value="All">All</option>
                                <!-- <option value="0">All School</option>-->
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
                                    <input type="hidden" name="schoolname" id="schoolname" value="<?php echo $_REQUEST['schoolname'] ?>" />
                              </div>
                              <div class="col-sm-2">
                                <select name="admission_course" id="admission_course" class="form-control">
                                 <option value="">Select Course</option>
                                 <!-- <option value="0">All Courses</option>-->
                                  </select>
                                  <input type="hidden" name="admissioncourse" id="admissioncourse" value="<?php echo $_REQUEST['admissioncourse'] ?>" />
                              </div>

                              <!-- <div class="col-sm-2" id="semest">
                                <select name="admission_branch" id="stream_id" class="form-control">
                                  <option value="">Select Stream</option>
                                  <option value="all">All</option>
                                  </select>
                                   <input type="hidden" name="admissionbranch" id="admissionbranch" value="<?php echo $_REQUEST['admissionbranch'] ?>" />
                              </div> -->
                              <div class="col-sm-2" id="">
							  <input type="hidden" name="semester" id="semester" value="" class="form-control" />
                             <input type="submit" id="" class="btn btn-primary btn-labeled pull-right" value="Search" > 
                             </div>
                                 
                            </div>
                            </div>
                            </form>
                        </span>
                        <div class="holder1"></div>
                </div>
			
            <div class="table-info panel-body" style="overflow-x:scroll;height:500px; overflow-y:scroll;width:100%;">  
			<?php 
			$role_id=$this->session->userdata('role_id');?>
          

            
				<?php // }?>
			
                <div class="col-lg-12">
                <form name="Excelpost" id="Excelpost" method="post" action="<?=base_url()?>Certificate/Manual_excel">
                <input type="hidden" name="regulation" id="regulationex" value="">
                <input type="hidden" name="exam_session" id="exam_sessionex" value="">
                <input type="hidden" name="school_code" id="school_codeex" value="">
                <input type="hidden" name="admission_course" id="admission_courseex" value="">
                <input type="hidden" name="stream_id" id="stream_idex" value="">
                <input type="hidden" name="admissionbranch" id="admissionbranchex" value="">
                <input type="hidden" name="semester" id="semesterex" value="">
                <input type="hidden" name="schoolname" id="schoolnameex" value="">
                <input type="hidden" name="admissioncourse" id="admissioncourseex" value="">
                <input type="hidden" name="admission_branch" id="admission_branchex" value="">
              
                </form>
                
                
                
                    <div class="table-info" id="stddata" >    
				<?php 	
					if($_POST){
				
				?>
				<form name="mrkcrdfrom" id="mrkcrdfrom" method="post" action="<?=base_url()?>Certificate/download_degree_certificate_new_for_rank">
                <div class="row" style="">
                     
                    </div>
                     <div class="row">&nbsp;&nbsp;
                     <input type="hidden" name="semester" id="ressemester" value="<?=$semester?>">
                        	<input type="hidden" name="school" value="<?=$school_code?>">
                        	<input type="hidden" name="count" value="<?=count($stud_list)?>">
                            <input type="hidden" name="school_code" value="<?=$school_code?>">
                        	<input type="hidden" name="stream_id" id='resstream_id' value="<?=$stream?>">
                            <input type="hidden" name="exam_id" id='resstream_id' value="<?=$exam_id?>">
                        	<input type="hidden" name="exam_session" id="resexam_session" value="<?=$exam_month.'~'.$exam_year.'~'.$exam_id?>">
                     <br /></div>
               <table id="example" class="table-bordered display nowrap" style="width:100%">
                         
              
                        <thead>
                                 

                             
                            <tr>
                                   <th class="noExl"><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th>
                                    <th>S.No.</th>
									
                                    <th>PRN</th>
                                    <th>Student Name</th>
                                    <th>Photo</th>
                                    <th>Course Name</th>
                                    <th>Stream Name</th>
									<th>Classification</th>
                                    <th>CGPA</th>
                                    <th>Rank</th>
                                    <th>Session</th>
                                    <!-- <th>Attempt</th>
                                   <th>Status</th> -->
                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        	  


                            <?php
                             $CI =& get_instance();
						     $CI->load->model('Results_model');
						     $CI->load->model('Certificate_model');

						  for($sl =0;$sl<count($stream_list); $sl++){

						  	//echo "<pre>";
							//print_r($stream_list[$sl]['stream_id']);exit;

							$stud_list = $this->Certificate_model->list_result_students_for_rank_for_all($this->data['school_code'],$this->data['admission_seeion'],$this->data['exam_id'],$stream_list[$sl]['stream_id']);  
                          $CI =& get_instance();
						  $CI->load->model('Results_model');

						    $kk =1;
                            $j=1;  $Honours='0'; $Distinction='0';  $FirstClass='0';     $SecondClass='0';   $ThirdClass='0'; 

                                       
                            for($i=0;$i<count($stud_list);$i++)
                            {
								if(!empty($stud_list[$i]['Result'])){
									$res_uniq_sem = $this->Results_model->fetch_student_unique_result_semester($stud_list[$i]['stud_id'],$exam_id);
									$res_uniq_subjects = $this->Results_model->fetch_student_subject_completion($stud_list[$i]['stud_id']);
									$check_drop_out  = $this->Results_model->check_drop_out($stud_list[$i]['stud_id']);
									if($stud_list[$i]['admission_year']==1){
										$s=1;
									}else{
										$s=3;
									}

									for ($x = $s; $x <= $stud_list[$i]['current_semester']; $x++) {
										$studallsem[]=$x;
									}
									foreach($res_uniq_sem as $rsem){
									 $res_uniq_sems[] = $rsem['semester'];  
									}	
									$uniq_sems=array_diff($studallsem,$res_uniq_sems);
									/*if($stud_list[$i]['enrollment_no']=='170101062100'){
										echo 'gfg';print_r($studallsem);echo '<br>';print_r($res_uniq_sems);echo '<br>';print_r($uniq_sems);exit;
									}*/
									if(empty($uniq_sems) && empty($res_uniq_subjects) && empty($check_drop_out)){
                            ?>
	
							 
                            <tr>
						<td class="noExl">
						
                            <input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?=$stud_list[$i]['enrollment_no']?>">
                            <input type="hidden" name="stream_idn[]" id='resstream_id' value="<?=$stud_list[$i]['stream_id']?>">
                            <input type="hidden" name="exam_idn[]" id='resstream_id' value="<?=$stud_list[$i]['exam_id']?>">
                            <input type="hidden" name="rank[]" id='rank_id' value="<?=$kk?>">
                            </td>
                              <td><?=$j?></td>
                        		<!--input type="hidden" name="stud_prn[]" style="width:30px" value="<?=$stud_list[$i]['enrollment_no']?>">
                        		<input type="hidden" name="stud_id[]" style="width:30px" value="<?=$stud_list[$i]['student_id']?>"-->
                                <td><?=$stud_list[$i]['enrollment_no']?></td> 
                                <td><?=$stud_list[$i]['first_name'].$stud_list[$i]['middle_name'].$stud_list[$i]['last_name'];?></td> 	
                                <td><img src="<?=base_url()?>uploads/student_photo/<?=$stud_list[$i]['enrollment_no']?>.jpg" alt="<?=$stud_list[$i]['student_id']?>" width="15" ></td>
                                <td><?= $stud_list[$i]['course_short_name']?></td>
                                <td><?= $stud_list[$i]['stream_name']?></td>

								<td><?php $stud_list[$i]['Result'];
								   if(($stud_list[$i]['Result']=="Honours")){
									echo "FCH";
									}else if($stud_list[$i]['Result']=="Distinction") {
									echo "FWD";
									}else if($stud_list[$i]['Result']=="First Class") {
									echo "FC";	
									}else if($stud_list[$i]['Result']=="Second Class") {
									echo "SC";	
									}else if($stud_list[$i]['Result']=="Third Class") {
									echo "TC";	
									}
								
								?>
                                <?php if(($stud_list[$i]['Result']=="Honours")){
									$Honours +=1;
									}else if($stud_list[$i]['Result']=="Distinction") {
									$Distinction +=1;
									}else if($stud_list[$i]['Result']=="First Class") {
									$FirstClass +=1;	
									}else if($stud_list[$i]['Result']=="Second Class") {
									$SecondClass +=1;	
									}else if($stud_list[$i]['Result']=="Third Class") {
									$ThirdClass +=1;		
									}
									?>
                                </td> 
                                
                                <td><?=$stud_list[$i]['cumulative_gpa'];?></td>

                                <td>
                                	<?php
                                         if($kk == 1){
                                           echo 'Gold Medal';
                                         }elseif($kk ==2){
                                           echo 'Silver Medal';
                                         }elseif($kk == 3){
                                           echo 'Bronze Medal';
                                         }
                                             
                                	  ?>

                                </td>
                                <td><?=$stud_list[$i]['exam_month'].'-'.$stud_list[$i]['exam_year'];?></td>
                                <!-- <td><?php if($stud_list[$i]['checb']==0){ echo 'First Attempt'; }else{ echo '-';} ?></td>
								<td><?php if(empty($stud_list[$i]['markscard_no'])){ echo 'Pending'; }else{ echo $stud_list[$i]['markscard_no'];} ?></td> -->
												
                            </tr>
                            <?php

                              

                              $kk++;
                           
                         
                            $j++;
                           
							unset($uniq_sems);
							unset($studallsem);
							unset($res_uniq_sems);
							unset($res_uniq_subjects);
									}
								}
							}

						}
                            ?>  
                        
                       
                     

 <!-- <tr>
<td>FCH</td>
<td>FWD</td>
<td>FC</td>
<td>SC</td>
<td>TC</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr> 
<tr>
<td><?php echo $Honours; ?></td>
<td><?php echo $Distinction; ?></td>
<td><?php echo $FirstClass; ?></td>
<td><?php echo $SecondClass; ?></td>
<td><?php echo $ThirdClass; ?></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>  -->
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
		$("#mrkcrdfrom").submit();
		//return true;
	}
} 	
//$(document).ready(function () {
	$('#chk_stud_all').change(function () {
        $('.studCheckBox').prop('checked', $(this).prop('checked'));
   // });
	
		//Allocate batch
	$('#gmarkscard').on('click', function () {
		//alert("hi");
			var chk_stud = $("#chk_stud").val();
			var admission_stream = $("#resstream_id").val();
			var semester = $("#ressemester").val();
			var exam_session = $("#resexam_session").val();
			//alert(exam_session);
			var chk_checked = [];
            $.each($("input[name='chk_stud[]']:checked"), function(){            
                chk_checked.push($(this).val());
            });
			var arr_length = chk_checked.length;
			if(arr_length ==0){
				return false;
			}
			if (arr_length !=0) {
			var chk_stud=chk_checked;
					var url ='<?= base_url() ?>Certificate/generate_markscard_excel/'+chk_stud+'/'+semester+'/'+admission_stream+'/'+exam_session;
					alert(url);
					window.location.href = url;
					//data: {,semester:sem,admission_stream:stream,exam_session:exam_session},

			} else {
				$('#studtbl').html('<option value="">No data found</option>');
			}
		});
});
	
	function getBase64Image_k(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;

    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    var dataURL = canvas.toDataURL("image/png");

    return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
}
	
function getBase64Image(img) {
    var canvas = document.createElement("canvas");
    canvas.width = img.width;
    canvas.height = img.height;
    var ctx = canvas.getContext("2d");
    ctx.drawImage(img, 0, 0);
    return canvas.toDataURL("image/png");
}

 $("#Excelcard1").on('click', function () {
		
		$("#regulationex").val($("#regulation").val());
		$("#exam_sessionex").val($("#exam_session").val());
		$("#school_codeex").val($("#school_code").val());
		$("#admission_courseex").val($("#admission_course").val());
		$("#stream_idex").val($("#stream_id").val());
		$("#admissionbranchex").val($("#admissionbranch").val());
		$("#semesterex").val($("#semester").val());
		$("#schoolnameex").val($("#schoolname").val());
		$("#admissioncourseex").val($("#admissioncourse").val());
		$("#admission_branchex").val($("#stream_id").val());
		$( "#Excelpost" ).trigger( "submit" );		
		
	});
	
	
	 $("#pdfcard1").on('click', function () {
		
		$("#regulationex").val($("#regulation").val());
		$("#exam_sessionex").val($("#exam_session").val());
		$("#school_codeex").val($("#school_code").val());
		$("#admission_courseex").val($("#admission_course").val());
		$("#stream_idex").val($("#stream_id").val());
		$("#admissionbranchex").val($("#admissionbranch").val());
		$("#semesterex").val($("#semester").val());
		$("#schoolnameex").val($("#schoolname").val());
		$("#admissioncourseex").val($("#admissioncourse").val());
		$("#admission_branchex").val($("#stream_id").val());
		$("#Excelpost").attr("action",'<?=base_url()?>Certificate/Manual_Pdf');
		$("#Excelpost").trigger("submit");
		
		
		
	});

</script>

<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.2/js/buttons.html5.min.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.2/css/buttons.dataTables.min.css">
<script>
	$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            'excel'
        ],
        "bPaginate": false
    } );
} );
</script>