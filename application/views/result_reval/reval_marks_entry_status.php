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
			'url' : base_url + '/Result_reval/load_streams_for_reval_result',
			'type' : 'POST', //the way you want to send data to your URL
			'data' : {'course' : type},
			'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
				var container = $('#semest'); //jquery selector (get element by id)
				if(data){
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
				url: '<?= base_url() ?>Result_reval/load_schools_for_reval_results',
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
				url: '<?= base_url() ?>Result_reval/load_schools_for_reval_results',
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
				url: '<?= base_url() ?>Result_reval/load_streams_for_reval_result',
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
			var exam_session =$("#exam_session").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Result_reval/load_examsemesters',
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
		var exam_session =$("#exam_session").val();
			if (stream_id1) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Result_reval/load_examsemesters',
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
				url: '<?= base_url() ?>Result_reval/load_streams_for_reval_result',
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Reval Marks Entry Status</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">    
                   	 <?php if(!empty($this->session->flashdata('msg'))){ ?>
					  <div class="row" style="color:green">					 
				  <?php  echo $this->session->flashdata('msg');?>                    
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
					 <?php } ?>
					 <?php if(!empty($this->session->flashdata('msg1'))){ ?>
					  <div class="row" style="color:red">					 
				  <?php  echo $this->session->flashdata('msg1');?> 
                    <hr class="visible-xs no-grid-gutter-h">
                </div>
				<?php } ?>
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
                            <form method="post" action ="<?=base_url()?>Result_reval/entry_reval_status">	
                            <div class="form-group">
							 <div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required>
                                 <option value="">Exam Session</option>                               
                                  <?php

									foreach ($exam_session as $exsession) {
										$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
										$exam_sess_val = $exsession['exam_month'] .'-'.$exsession['exam_year'] .'-'.$exsession['exam_id'];
									    if ($exam_sess_val == $_POST['exam_session']) {
									        $sel = "selected";
									    } else {
									        $sel = '';
									    }
									    echo '<option value="' . $exam_sess_val. '"' . $sel . '>' .$exam_sess.'</option>';
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
                             </div>							
                              <div class="col-sm-2" id="semest">
                                 <input type="submit" id="" class="btn btn-primary btn-labeled" value="Search" > 
                            </div>
                            </div>
                            </form>
                        </span>
                        <div class="holder1"></div>
                </div>
			
            <div class="table-info panel-body" >  			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" style="<?=$tbstyle?>">    
				<?php 	
					if($_POST){				
				?>
			
      <table class="table table-bordered" id="table2excel">
                        <thead>
                              <tr>
								<th>S.No.</th>									
								<th>Subject Code</th>
								<th>Subject Name</th>
								<th>Theory Marks</th>
								<th>CIA Marks</th>
								<th>Download</th>
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                            <?php
                          $arr_status=0;
                            $j=1;                            
                            for($i=0;$i<count($sub_list);$i++)
                            {

                            ?>
							<input type="hidden" name="subject_id[]" id="subject_id<?=$j?>" class='studCheckBox' value="<?=$sub_list[$i]['sub_id']?>">
							<input type="hidden" name="subject_code[]" id="subject_code<?=$j?>" class='studCheckBox' value="<?=$sub_list[$i]['subject_code']?>">
							 <?php if($sub_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$sub_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
                              <td><?=$j?></td>                       
                                 <td><?=$sub_list[$i]['subject_code']?><?php //$sub_list[$i]['subject_id'];?></td> 
                                    <td>							
							<?php
								echo $sub_list[$i]['subject_name'];
								?>
								</td> 
								<td>
									<?php
									if($sub_list[$i]['th_status']=='Y' && ($sub_list[$i]['stud_count'] ==$sub_list[$i]['th_entry'])){
										echo "Entered";
									}elseif($sub_list[$i]['th_status']=='Y' && ($sub_list[$i]['stud_count'] !=$sub_list[$i]['th_entry'])){
										echo "Not Entered";
										$arr_status=1;
										$arr_stat[]=1;
									}else if($sub_list[$i]['pr_status']=='Y' && ($sub_list[$i]['stud_count'] ==$sub_list[$i]['pr_entry'])){
										echo "Entered";
									}elseif($sub_list[$i]['pr_status']=='Y' && ($sub_list[$i]['stud_count'] !=$sub_list[$i]['pr_entry'])){
										echo "Not Entered";
										$arr_status=1;
										$arr_stat[]=1;
									}else{
										echo "NA";
										$arr_status=0;
									}									
								?>
								</td> 
								<td>
									<?php
									if($sub_list[$i]['cia_status']=='Y' && ($sub_list[$i]['stud_count'] ==$sub_list[$i]['cia_entry'])){
										echo "Entered";
									}elseif($sub_list[$i]['cia_status']=='Y' && ($sub_list[$i]['stud_count'] !=$sub_list[$i]['cia_entry'])){
										echo "Not Entered";
										$arr_status=1;
										$arr_stat[] = 1;
									}else{
										echo "NA";
									}
								?>
								</td> 
 
								<td>
									<?php
									$subDetails = $sub_list[$i]['subject_id'].'~'.$school_code.'~'.$admissioncourse.'~'.$stream.'~'.$semester.'~'.$exam.'~'.$marks_type;
									if($sub_list[$i]['cia_status'] =='Y' || $sub_list[$i]['th_status'] =='Y' || $sub_list[$i]['pr_status'] =='Y') {	 
									?>
                                    <a href="<?=base_url($currentModule."/download_mrkdentrystatus_pdf/".base64_encode($subDetails).'/'.base64_encode($sub_list[$i]['m_me_id']).'/'.base64_encode($sub_list[$i]['c_me_id']))?>"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i></a>
									<?php } ?>
								</td>								
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>  						
                    <?php } ?>
                    <?php 
						$exam_month1 = str_replace('/','_', $exam_month);
                    	$result_data = $school_code.'~'.$stream.'~'.$semester.'~'.$exam_month1.'~'.$exam_year.'~'.$exam_id;
						$hidden="";
                    	//if($sub_list[0]['result_reval_marks'] =='')
						{
							//$hidden="hidden";
							
                    ?>
                    <input type="hidden" id="res_data" name="res_data" value="<?=$result_data?>">
                    <div class="row <?=$hidden?>" >
                    	<div class="col-lg-12">
                    		<div class="col-sm-4"></div>
                    		<div class="col-sm-3" id="resp" style="display:none;"><img src='<?=base_url()?>assets/images/demo_wait_b.gif'/></div>
                    			<button class="btn btn-primary" id="mrkentup">Reval Marks Update</button>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<button class="btn btn-primary" id="emsexcl">Marks Entry Status Excel</button></div>
                    							
                    	</div>
                    </div>
                    <?php }?>
					<div class="col-sm-2"id="rgm"></div>		
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
$('.mt').click(function(){
			var checkstr =  confirm('Are you sure you want to delete this?');
			if(checkstr == true){
			  // do your code
			}else{
			return false;
			}
			});
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

// comulative marks entry excel
	$('#emsexcl').on('click', function () {	
		var res_data = $("#res_data").val();
		if (res_data) {
			window.location.href = '<?= base_url() ?>Result_reval/excel_RevalMrkEntryStatus/'+res_data;
		} else {
			
		}
	});


	
	$('#mrkentup').on('click', function () {	
		var res_data = $("#res_data").val();
		if (res_data) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>result_reval/exam_result_update',
				data: 'res_data=' + res_data,
				success: function (responce) {
					//alert(html);
					if(responce='success'){
						//alert(responce);
						$('#rgm').html("Reval Result Forwarded Successfully!");
					}else{
						$('#rgm').html("problem while forwarding!");
					}
					
				}
			});
		} else {
			
		}
	});	
	
} );
$(document).ajaxStart(function(){
    $('#resp').show();
 }).ajaxStop(function(){
    $('#resp').hide();
 });
</script>