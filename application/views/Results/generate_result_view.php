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
			'url' : base_url + '/Examination/load_streams_for_result',
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
				url: '<?= base_url() ?>Examination/load_schools_for_results',
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
				url: '<?= base_url() ?>Examination/load_schools_for_results',
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
				url: '<?= base_url() ?>Examination/load_streams_for_result',
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
				url: '<?= base_url() ?>Examination/load_streams_for_result',
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
        <li class="active"><a href="#">Results</a></li>
        <li class="active"><a href="#">Generate</a></li>
    </ul>
    <div class="page-header">
    	<div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Generate Result</h1>
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
                            <form method="post" action ="<?=base_url()?>Results/generate">	
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
									?>
									
									</select>
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

                              <div class="col-sm-2" id="semest">
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
<!--button class="btn btn-primary pull-right" id="<?=$stream_list[$i]['semester']?>" onclick="calculate_gpa()" style="margin-right:35px;margin-bottom: 10px;">Generate GPA </button-->
<div class="table-responsive">
<table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <!--th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th-->
                                    <th>S.No.</th>
									
                                    <th>Stream Name</th>
                                     <th>Semester</th>
									 <th>Result Status</th>
                                     <th>Marks-Sheet</th>      
                                     <th>Grade-Sheet </th>    
                                     <th>Action</th>   
                                     <th>GPA Generation</th>   
									 
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        <?php 
						$exam_month1 = str_replace('/','_', $exam_month);
						
                    	$result_data = $school_code.'~'.$stream.'~'.$exam_month1.'~'.$exam_year.'~'.$exam_id;
                    	?>
                        	  <input type="hidden" id="res_data" name="res_data" value="<?=$result_data?>">

                            <?php
                           // echo "<pre>";
							//print_r($stream_list);
                          
                            $j=1;  
                            if(!empty($stream_list)){                          
                            for($i=0;$i<count($stream_list);$i++)
                            {
                               //echo $stream_list[$i]['isPresent']; 
                            ?>
							<input type="hidden" name="res_detail_id" id="<?=$stream_list[$i]['semester']?>_res_detail_id" value="<?=$stream_list[$i]['res_detail_id']?>">
							 <?php if($stream_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$stream_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
							
                              <td><?=$j?></td>
								<td><?=$stream_list[$i]['stream_short_name']?></td> 
								<td><?=$stream_list[$i]['semester']?></td> 
								<td id="<?=$stream_list[$i]['semester']?>_res_status">
									<?php if($stream_list[$i]['result_generated']=='Y'){  echo "<span style='color:green;'>Generated</span>";}else{ echo "<span style='color:red;'>Not Generated</span>";}?>
									
								</td> 
                                <td>
									<a href="#"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px;color:red;margin-left:15px;" title="PDF" id="<?=$stream_list[$i]['semester']?>~pdf" onclick="generate_pdfreport(this.id,'1')" target="_blank"></i> &nbsp; | <i class="fa fa-file-excel-o" aria-hidden="true" style="font-size:20px;color:green;margin-left:15px;" title="EXCEL" id="<?=$stream_list[$i]['semester']?>~excl" onclick="generate_excelreport(this.id,'2018')"></i></a><!-- <br>
                                    <a href="#">2 Year<i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px;color:red;margin-left:15px;" title="PDF" id="<?=$stream_list[$i]['semester']?>~pdf" onclick="generate_pdfreport(this.id,'2')" target="_blank"></i> &nbsp; | <i class="fa fa-file-excel-o" aria-hidden="true" style="font-size:20px;color:green;margin-left:15px;" title="EXCEL" id="<?=$stream_list[$i]['semester']?>~excl" onclick="generate_excelreport(this.id,'2018')"></i></a><br>
                                    <a href="#">3 Year<i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px;color:red;margin-left:15px;" title="PDF" id="<?=$stream_list[$i]['semester']?>~pdf" onclick="generate_pdfreport(this.id,'3')" target="_blank"></i> &nbsp; | <i class="fa fa-file-excel-o" aria-hidden="true" style="font-size:20px;color:green;margin-left:15px;" title="EXCEL" id="<?=$stream_list[$i]['semester']?>~excl" onclick="generate_excelreport(this.id,'2017')"></i></a><br>
                                    <a href="#">4 Year<i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px;color:red;margin-left:15px;" title="PDF" id="<?=$stream_list[$i]['semester']?>~pdf" onclick="generate_pdfreport(this.id,'4')" target="_blank"></i> &nbsp; | <i class="fa fa-file-excel-o" aria-hidden="true" style="font-size:20px;color:green;margin-left:15px;" title="EXCEL" id="<?=$stream_list[$i]['semester']?>~excl" onclick="generate_excelreport(this.id,'2016')"></i></a> -->
                                
                                </td>

                                	<td>
									<?php //if($stream==71){ ?>
									<!--a href="#"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px;color:red;margin-left:15px;cursor:pointer;" title="PDF" id="<?=$stream_list[$i]['semester']?>~pdf" onclick="generate_pdfreport_dpharma(this.id,'1')">
									</i></a-->
									<a href="#"><i class="fa fa-file-pdf-o" aria-hidden="true" style="font-size:20px;color:red;" title="PDF" id="<?=$stream_list[$i]['semester']?>~excl" onclick="gradesheet_excelreport(this.id,'1')" target="_blank"></i></a>
									<?php //}?>
									</td>

                                <td>
                                	<?php if($stream_list[$i]['result_generated']=='N' && $stream_list[$i]['result_regenerated']=='N'){ ?>
                                	<button class="btn btn-primary" id="<?=$stream_list[$i]['semester']?>" onclick="generate_grade(this.id)">Generate</button>
                                	<?php 
                                		}else{ 
										if($stream_list[$i]['is_verified']=='N'){
										?>
                                			<button class="btn btn-primary" id="<?=$stream_list[$i]['semester']?>" onclick="generate_grade(this.id)">ReGenerate</button>
											<button class="btn btn-primary" id="<?=$stream_list[$i]['res_detail_id']?>" onclick="updateResultStatus(this.id)">Verify</button>
											<button class="btn btn-primary" id="<?=$stream_list[$i]['semester']?>" onclick="deleteResult(this.id)">Delete</button>
											<!--button class="btn btn-primary" id="<?=$stream_list[$i]['semester']?>" onclick="calculate_sgpa(this.id)">Generate GPA </button-->
                                	<?php	}else{
										  echo "<span style='color:green;'>Verified</span>";
									}
										}
                                	?>
                                	 
                    
                                </td>  		
								
								<td>
									<?php 
										if($stream_list[$i]['is_verified']=='Y'){ 
									?>
                                    <button class="btn btn-success btn-sm" onclick="generateGrade('sgpa','<?=$stream_list[$i]['stream_id']?>')">
                                        SGPA
                                    </button>
                                    <button class="btn btn-info btn-sm" onclick="generateGrade('cgpa','<?=$stream_list[$i]['stream_id']?>')">
                                        CGPA
                                    </button>
                                    <button class="btn btn-warning btn-sm" onclick="generateGrade('gpa','<?=$stream_list[$i]['stream_id']?>')">
                                        GPA
                                    </button>
									<?php 
										} 
									?>
                                </td>
                            </tr>
                            <?php
                            $j++;
                            }
                        }else{
                        	echo "<tr><td colspan='6'>No data found.</td></tr>";
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
</div>

<script src="https://cdn.datatables.net/1.10.15/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.flash.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.27/build/pdfmake.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.3.1/js/buttons.html5.min.js"></script>

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.3.1/css/buttons.dataTables.min.css">

<script>
function calculate_gpa() {
	var exam_id ='<?=$exam_id?>';
            if(confirm("Are you sure to Generate GPA?")){
				if (exam_id !='') {
					$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Results/calculate_gpa',
						data: {exam_id:exam_id},
						success: function (data1) {
							//alert(data1);
								if(data1=='SUCCESS'){	
									//$('#alrtmsg').html('Grade Updated Successfully');
									alert('GPA Updated Successfully');
									
								}
								else{
									alert("Problem while updating GPA.");	
									return true;
								}
						}
					});
				} else {
					alert("Problem while updating Grade");
				}
			} else {

            return false;
        }

	return true;
}
function calculate_sgpa(sem) {
	var semester = sem;
	var exam_id ='<?=$exam_id?>';
            if(confirm("Are you sure to Generate GPA?")){
				if (semester !='') {
					$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Results/calculate_sgpa',
						data: {exam_id:exam_id,semester:semester},
						success: function (data1) {
							//alert(data1);
								if(data1=='SUCCESS'){	
									//$('#alrtmsg').html('Grade Updated Successfully');
									alert('SGPA Updated Successfully');
									
								}
								else{
									alert("Problem while updating GPA.");	
									return true;
								}
						}
					});
				} else {
					alert("Problem while updating Grade");
				}
			} else {

            return false;
        }

	return true;
}
function updateResultStatus(resid) {
	var result_id = resid;
            if(confirm("Are you sure to Verify the Result?")){
				if (result_id !='') {
					$.ajax({
						type: 'POST',
						url: '<?= base_url() ?>Results/updateResultStatus',
						data: {result_id:result_id},
						success: function (data1) {
							//alert(data1);
								if(data1=='SUCCESS'){	
									//$('#alrtmsg').html('Grade Updated Successfully');
									alert('Verified Successfully');
									
								}
								else{
									alert("Problem while updating Grade.");	
									return true;
								}
						}
					});
				} else {
					alert("Problem while updating Grade");
				}
			} else {

            return false;
        }

	return true;
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
});	

$(document).ready(function() {
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",

    name: "Worksheet Name",
   filename: "Student List" //do not include extension

  });

});


} );

function generate_grade(sem) {
		var res_data = $("#res_data").val();
		//alert(res_data+'~'+sem);_res_detail_id
		var res_detail_id = $('#'+sem+'_res_detail_id').val();
		//alert(res_detail_id);
		if (res_data) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Results/grade_generation',
				data: {res_data:res_data+'~'+sem,res_detail_id:res_detail_id},
				success: function (responce) {
					//alert(responce);
					if(responce='success'){
						$('#'+sem+'_res_status').html('Generated');
						//alert("Result Generated Successfully!");
						$('#rgm').html("Result Generated Successfully!");
					}
					
				}
			});
		} else {
			
		}
		return true;
	}
	function deleteResult(sem) {
		var res_data = $("#res_data").val();
		//alert(res_data+'~'+sem);_res_detail_id
		var res_detail_id = $('#'+sem+'_res_detail_id').val();
		//alert(res_detail_id);
		if (res_data) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Results/deleteResult',
				data: {res_data:res_data+'~'+sem,res_detail_id:res_detail_id},
				success: function (responce) {
					//alert(responce);
					if(responce='success'){
						$('#'+sem+'_res_status').html('Generated');
						alert("Result Deleted Successfully!");
						location.reload(true);
						$('#rgm').html("Result Deleted Successfully!");
					}
					
				}
			});
		} else {
			
		}
		return true;
	}	
function generate_excelreport(sem, batch) {
	//alert(sem);
		var res_data = $("#res_data").val();
		//alert(res_data+'~'+sem);
		window.location.href = '<?= base_url() ?>Results/excel_resultReport/'+res_data+'~'+sem+'/'+batch;
		// if (res_data) {
		// 	$.ajax({
		// 		type: 'POST',
		// 		url: '<?= base_url() ?>Results/excel_resultReport',
		// 		data: 'res_data=' + res_data+'~'+sem,
		// 		success: function (responce) {
		// 			//alert(responce);
		// 			if(responce='success'){
		// 				//alert("Result Generated Successfully!");
		// 				$('#rgm').html("Result Generated Successfully!");
		// 			}
					
		// 		}
		// 	});
		// } else {
			
		// }
		return true;
	}
	function gradesheet_excelreport(sem, batch) {
	//alert(sem);
		var res_data = $("#res_data").val();
		//alert(res_data+'~'+sem);
		window.location.href = '<?= base_url() ?>Results/gradesheet_pdfreport/'+res_data+'~'+sem+'/'+batch;
		return true;
	}
function generate_pdfreport(sem,batch) {
	//alert(sem);
		var res_data = $("#res_data").val();
		//alert(res_data+'~'+sem);
		window.location.href = '<?= base_url() ?>Results/pdf_resultReport/'+res_data+'~'+sem+'/'+batch;
		return true;
	}	
function generate_pdfreport_dpharma(sem,batch) {
	//alert(sem);
		var res_data = $("#res_data").val();
		var dpharma ='Y';
		var gdview ='Y';
		//alert(res_data+'~'+sem);
		window.location.href = '<?= base_url() ?>Results/pdf_resultReport/'+res_data+'~'+sem+'~'+dpharma+'~'+gdview+'/'+batch;
		return true;
	}	
$(document).ajaxStart(function(){
    $('#resp').show();
 }).ajaxStop(function(){
    $('#resp').hide();
 });	
</script>

<script> /*
function generateGrade(type, stream_id) {
    let baseUrl = "<?= base_url('Results/') ?>";
    let url = "";

    if (type === 'sgpa') url = baseUrl + "/generate_sgpa";
    else if (type === 'cgpa') url = baseUrl + "/generate_cgpa";
    else if (type === 'gpa') url = baseUrl + "/generate_gpa";

    $.ajax({
        url: url,
        type: "POST",
        dataType: "json",
        data: { stream_id: stream_id },
        success: function(response) {
            if (response.status === 'success') {
                alert(response.message);
            } else {
                alert("Error: " + response.message);
            }
            console.log(response);
        },
        error: function() {
            alert("Server error while generating " + type.toUpperCase());
        }
    });
}*/ 
</script>