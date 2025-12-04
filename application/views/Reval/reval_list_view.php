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
			'url' : base_url + 'Examination/load_streams',
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
<?php
$reval = $this->session->userdata('reval');
if($reval==0){
    $report_name="PHOTOCOPY";
    $reportName="Photocopy";
}else{
    $report_name="REVALUATION";
    $reportName="Revaluation";
}    
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#"><?=$reportName?></a></li>
        <li class="active"><a href="#"></a></li>
    </ul>
    <div class="page-header">
    	<div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-list page-header-icon"></i>&nbsp;&nbsp;Photocopy / Revaluation List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row"> 
					<a href="<?=base_url()?>Reval/search_student_admin" target="_blank"><button class="btn btn-primary pull-right" style="margin-right:15px;">Add</button></a>				
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
                            <form method="post" action ="<?=base_url()?>Reval/list_applied">	
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
									<!--option value="MAY-2022-26" selected="">MAY-2022</option-->
									</select>
                              </div>
							<div class="col-sm-2">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select School</option>
                                 <option value="0" <?php if($_REQUEST['school_code']==0){ echo "selected";}?>>All School</option>
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
                                <select name="reval_type" id="reval_type" class="form-control" required>
                                  <option value="">Select Type</option>
                                  <option value="1" <?php if($_REQUEST['reval_type']==1){ echo "selected";}?>>Revaluation</option>
                                  <option value="0" <?php if($_REQUEST['reval_type']==0){ echo "selected";}?>>Photocopy</option>
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
			
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <!--th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th-->
                                    <th>S.No.</th>
									<th>PRN.</th>	
                                    <th>Student Name</th>
                                     <th>Semester</th>
									 <th>Stream Name</th> 
									 <?if($reval==0){ ?>
									 <th>Photocopy Fees</th>
            						<?php }else{ ?>
 									<th>Revaluation Fees</th> 	
            						<?php }  ?> 
									 <th>No. Subjects</th>
									 <th>Payment Status</th>
                                     <th>Action</th>            
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        <?php 
                    	$result_data = $school_code.'~'.$stream.'~'.$exam_month.'~'.$exam_year.'~'.$exam_id;
                    	?>
                        	  <input type="hidden" id="res_data" name="res_data" value="<?=$result_data?>">

                            <?php
                            //echo "<pre>";
							//print_r($rev_list);exit;
                          
                            $j=1;  
                            if(!empty($rev_list) ){                          
                            foreach ($rev_list as $key => $value) {
                               if($reval==0){
					                $fees =$value['photocopy_fees']; 
					            }else{
					                $fees =$value['reval_fees']; 
					            }
                             //if(!empty($value['amount'])){								
                            ?>				
                            <tr>
                              <td><?=$j?></td>
                              <td><?=$value['enrollment_no']?></td>
								<td><?=$value['stud_name']?></td> 
								<td><?=$value['semester']?></td> 
								<td><?=$value['stream_short_name']?></td>
								<td><?=$fees?></td>
								<td><?=$value['sub_cnt']?></td>
								<td><?php if(empty($value['amount'])){ ?> <span style="color:red">Not Paid</span>
								<?php }else{?>
								<span style="color:green"><b>Paid</b></span>	
								<?php 
								}?></td>
                                <td width='150px'><a href="<?=base_url()?>Reval/search_student_admin/<?=$value['enrollment_no']?>/<?=$exam_id?>/<?=$reval_type?>" target="_blank"><button class="btn btn-primary btn-xs" id="v_sd">View</button></a> | <a href="<?=base_url()?>Reval/remove_reval/<?=$value['enrollment_no']?>/<?=$exam_id?>" target="_blank"><button class="btn btn-primary btn-xs" id="v_sd">Delete</button></a></td>
                            </tr>
                            <?php
                            $j++;
                            }
                        //}
							}else{
                        	echo "<tr><td colspan='6'>No data found.</td></tr>";
                        }
                            ?>                            
                        
                        </tbody>
                    </table> 
                    <button class="btn-primary" id="ex_list">Excel</button> 	
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
    $('#ex_list').on('click', function () {	
    	var stream_id = '<?=$stream?>'
    	var exam_id= '<?=$exam_id?>';
    	window.location.href = '<?= base_url() ?>Reval/excel_applied_list/'+stream_id+'/'+exam_id;
	}); 
});
	
</script>