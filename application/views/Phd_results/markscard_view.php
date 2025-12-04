<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?php echo base_url('assets/javascripts') . '/bootstrap-datepicker.js' ?> "></script>
<style>
.table.dataTable {
    width: 100%!important;
}
</style>
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
			'url' : base_url + '/Phd_results/load_edstreams',
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
				url: '<?= base_url() ?>Phd_examination/load_examsess_schools',
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
				url: '<?= base_url() ?>Phd_examination/load_examsess_schools',
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
		if (school_code) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Phd_results/load_edschools',
				data: {school_code:school_code,ex_ses:ex_ses},
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
			var ex_ses = $("#exam_session").val(); 
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Phd_results/load_edschools',
				data: {school_code:school_code,ex_ses:ex_ses},
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
		var ex_ses = $("#exam_session").val(); 
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Phd_results/load_edstreams',
				data: {course_id:admission_course,ex_ses:ex_ses},
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
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Phd_results/load_edsemesters',
					data: {stream_id:stream_id,ex_ses:ex_ses},
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
			if (stream_id1) {
				var ex_ses = $("#exam_session").val();   
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Phd_results/load_edsemesters',
					data: {stream_id:stream_id1,ex_ses:ex_ses},
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
				url: '<?= base_url() ?>Phd_examination/load_streams',
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
        <li class="active"><a href="#">Phd_examination</a></li>
        <li class="active"><a href="#">Phd_results</a></li>
    </ul>
    <div class="page-header">
    	<div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Markscard Generation</h1>
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
                            <form method="post" action ="<?=base_url()?>Phd_results/markscard">	
                            <div class="form-group">
							 <div class="col-sm-2" >
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
                                   <option value="1" <?php if($_REQUEST['semester'] ==1){ echo "selected";}else{}?>>1 </option>
                                   <option value="2" <?php if($_REQUEST['semester'] ==2){ echo "selected";}else{}?>>2 </option>
                                   <option value="3" <?php if($_REQUEST['semester'] ==3){ echo "selected";}else{}?>>3 </option>
                                   <option value="4" <?php if($_REQUEST['semester'] ==4){ echo "selected";}else{}?>>4 </option>
                                  </select>
                             </div><br><br>
                              <div class="col-sm-2 pull-right" id="semest">
                                 <input type="submit" id="" class="btn btn-primary btn-labeled pull-right" value="Search" > 
                            </div>
                            </div>
                            </form>
                        </span>
                        <div class="holder1"></div>
                </div>
			
            <div class="table-info panel-body" style="overflow-x:scroll;height:500px; overflow-y:scroll;width:100%;">  
			<?php 
			$role_id=$this->session->userdata('role_id');
			//if(isset($role_id) && $role_id==1 ){?>
          

            
				<?php// }?>
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" >    
				<?php 	
					if($_POST){
				
				?>
				<form name="mrkcrdfrom" id="mrkcrdfrom" method="post" action="<?=base_url()?>Phd_results/generate_markscard">
 					<table class="table table-bordered1" id="table2excel1">
                        <thead>
                            <tr>
                                   <th class="noExl"><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th>
                                    <th>S.No.</th>
									
                                    <th>PRN</th>
                                    <th>Student Name</th>
									<th>Semester</th>
									<th>Status(Clear/Hold)</th>
									<th>Remarks</th>
									<th>Arrears</th>

                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        	<input type="hidd" name="semester" id="ressemester" value="<?=$semester?>" style="display:none;">
                        	<input type="text" name="school" value="<?=$school_code?>" style="display:none;">
                        	<input type="text" name="stream_id" id='resstream_id' value="<?=$stream?>" style="display:none;">
                        	<input type="text" name="exam_session" id="resexam_session" value="<?=$exam_month.'~'.$exam_year.'~'.$exam_id?>" style="display:none;">
                            <?php
                            //echo "<pre>";
							//print_r($stud_list);
                          
                            $j=1;                            
                            for($i=0;$i<count($stud_list);$i++)
                            {
                            ?>
	
							 
                            <tr>
							<td class="noExl"><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?=$stud_list[$i]['stud_id']?>"></td>
                              <td><?=$j?></td>
                        		<!--input type="hidden" name="stud_prn[]" style="width:30px" value="<?=$stud_list[$i]['enrollment_no']?>">
                        		<input type="hidden" name="stud_id[]" style="width:30px" value="<?=$stud_list[$i]['student_id']?>"-->
                                <td><?=$stud_list[$i]['enrollment_no']?></td> 
                                <td><?=$stud_list[$i]['stud_name'];?></td> 	
								<td><?=$stud_list[$i]['semester'];?></td> 	
								<td></td> 
								<td></td> 	
								<td><a href="<?=base_url()?>Phd_examination/search_arrears/<?=$stud_list[$i]['enrollment_no']?>" target="_blank">View</a></td> 									
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>
						
					<div class="row">
						<div class="col-lg-2"><input type="radio" name="report_type" value="pdf" required>&nbsp;&nbsp; PDF</div>
						<!--div class="col-lg-2"><input type="radio" name="report_type" value="excel" required> &nbsp;&nbsp;EXCEL</div-->
						<div class="col-lg-3"><input type="text" style="width:200px" name="mrk_cer_date" id="mrk_cer_date" class="form-control" value="" placeholder="Select Date" ></div>
						<div class="col-lg-5"><input type="submit" name="generate" value="GENERATE MARKSCARD" id="gmarkscard1" class="btn btn-primary" onclick="return validate_student(this.value)"></div>
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
					var url ='<?= base_url() ?>Phd_results/generate_markscard_excel/'+chk_stud+'/'+semester+'/'+admission_stream+'/'+exam_session;
					alert(url);
					window.location.href = url;
					//data: {,semester:sem,admission_stream:stream,exam_session:exam_session},

			} else {
				$('#studtbl').html('<option value="">No data found</option>');
			}
		});
});	

$(document).ready(function() {
    $('#table2excel1').DataTable( {
        dom: 'Bfrtip',
		ordering: false,
		bPaginate: false,
        buttons: [
            {
                extend: 'excel',
                messageTop: 'Grade generation Student List'
            }
        ]
    } );
} );
</script>