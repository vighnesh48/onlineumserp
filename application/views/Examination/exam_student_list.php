<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>

<script>
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
					$('#school_code').html('<option value="0">Select ALL</option>');
					$('#school_code').html(html);
				}
			});
		} else {
			$('#school_code').html('<option value="">Select exam session first</option>');
		}
	}); 
//
	var exam_session = '<?=$ex_session?>';
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
		//alert(school_code);
		if (school_code) {
			//alert('inside');
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
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_ex_appliedstreams',
				data: {course_id:admission_course,exam_session:exam_session},
				success: function (html) {
					//alert(html);
					$('#stream_id').html(html);
					$("#stream_id option[value='" + admission_course + "']").attr("selected", "selected");
				}
			});
		} else {
			$('#stream_id').html('<option value="">Select course first</option>');
		}
	}); 
		//load semester
		$('#stream_id').on('change', function () {	
		var stream_id = $("#stream_id").val();
		var exam_session = $("#exam_session").val();
		//alert(admission_course);
		if (stream_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_ex_appliedsemesters',
				data: {stream_id:stream_id,exam_session:exam_session},
				success: function (html) {
					//alert(html);
					$('#semester').html(html);
					$("#semester option[value='" + stream_id + "']").attr("selected", "selected");
				}
			});
		} else {
			$('#semester').html('<option value="">Select stream first</option>');
		}
	}); 		
	// edit


		var stream_id = '<?=$stream?>';
		var exam_session = $("#exam_session").val();
		//alert(admission_course);
		if (stream_id) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_ex_appliedsemesters',
				data: {stream_id:stream_id,exam_session:exam_session},
				success: function (html) {
					//alert(html);
					$('#semester').html(html);
					var semester = '<?=$semester?>';
					$("#semester option[value='" + semester + "']").attr("selected", "selected");
				}
			});
		} else {
			$('#semester').html('<option value="">Select stream first</option>');
		}

var admission_course = '<?=$admissioncourse?>';
//alert(admission_course);
var exam_session = '<?=$ex_session?>';
		if (admission_course!='') {
			//alert('inside');
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Examination/load_ex_appliedstreams',
				data: {course_id:admission_course,exam_session:exam_session},
				success: function (html) {
					//alert(html);
					var stream_id = '<?=$stream?>';
					//alert(stream_id);
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
        <li class="active"><a href="#">Student Exam Status</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Exam List</h1>
            <div class="col-xs-12 col-sm-8">
                <div class="row">                    
                    <hr class="visible-xs no-grid-gutter-h">
                    <?php //if(in_array("Add", $my_privileges)) { ?>
                       
                    <div class="visible-xs clearfix form-group-margin"></div>
                    <?php// } ?>
                    <?php //if(in_array("Search", $my_privileges)) { ?>
                   <!--<form class="pull-right col-xs-12 col-sm-6" action="">
                        <div class="input-group no-margin">
                            <span style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="input-group-addon"><i class="fa fa-search"></i></span>
                            <select id="search_me" name="search_me" style="border:none;background: #fff;background: rgba(0,0,0,.05);" class="form-control no-padding-hr" placeholder="Search...">
                                <option value="">Select Title</option>
                                <?php
                                    for($i=0;$i<count($emp_list);$i++)
                                    {
                                ?>
                                <option value="<?=$emp_list[$i]['emp_id']?>"><?=$emp_list[$i]['fname'].' '.$emp_list[$i]['lname']?></option>
                                <?php
                                    }
                                ?>
                            </select>
                        </div>
                    </form>-->
                    <?php //} ?>
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
                            <form method="post">
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							 <div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required>
                                 <option value="">Exam Session</option>
                               
                                  <?php

foreach ($exam_session as $exsession) {
	$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
	$exam_sess_val = $exsession['exam_month'].'-'.$exsession['exam_year'].'-'.$exsession['exam_id'];
    if ($exam_sess_val == $_POST['exam_session']) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $exam_sess_val. '"' . $sel . '>' .$exam_sess.'</option>';
}
?>
<option value="MAY-2022-26">MAY-2022</option>
</select>
                              </div>
							<div class="col-sm-2">

                                <select name="school_code" id="school_code" class="form-control" >
                                 <option value="">Select School</option>
                                  <option value="0" <?php if($_POST['school_code']==0){ echo "selected";}else{}?>>All School</option>
                                  <?php
foreach ($schools as $sch) {
    if ($sch['school_code'] == $school_code) {
        $sel = "selected";
    } else {
        $sel = '';
    }
    echo '<option value="' . $sch['school_code'] . '"' . $sel . '>' . $sch['school_short_name'] . '</option>';
}
?>

</select>
                              </div>
                              <div class="col-sm-2">
                                <select name="admission-course" id="admission-course" class="form-control" >
                                 <option value="">Select Course</option>
                                  <option value="0">All Courses</option>
                                  </select>
                              </div>
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
                              <div class="col-sm-2" id="semest">
                                <select name="admission-branch" id="stream_id" class="form-control" >
                                  <option value="">Select Stream</option>
                                  <option value="0">All Stream</option>
                                  </select>
                              </div>
                              <div class="col-sm-2" id="">
                                <select name="semester" id="semester" class="form-control" >
                                  <option value="">Select Semester</option>
								 <option value="0">All Semester</option>
                                   <option value="1" <?php if($_REQUEST['semester'] ==1){ echo "selected";}else{}?>>1 </option>
                                   <option value="2" <?php if($_REQUEST['semester'] ==2){ echo "selected";}else{}?>>2 </option>
                                   <option value="3" <?php if($_REQUEST['semester'] ==3){ echo "selected";}else{}?>>3 </option>
                                   <option value="4" <?php if($_REQUEST['semester'] ==4){ echo "selected";}else{}?>>4 </option>
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

            <div class="table-info panel-body"  style="overflow:scroll;height:800px;">  
			<?php 
			$role_id=$this->session->userdata('role_id');
			if(isset($role_id) && $role_id==1 ){?>
            <form id="filterdata" method="post" action ="">

            </form>
				<?php }?>
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" style="<?=$tbstyle?>">    
				<?php 	
					if($_POST){
				
				?>
			
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <th class="noExl"><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th>
                                    <th>S.No.</th>
									
                                    <th>PRN</th>
                                    <th>Name</th>
									<th>Mobile</th>
									<th>Stream</th>
                                     <th>Sem</th>
                                     <th>Exam Fees</th>
									 <th>Fees Paid</th>									 
									 <th>Academic O/S</th>
									 <!--th>Attend (%)</th-->
                                     <!--th>Form Status</th-->
                                    <th>Exam Allow </th>							
									<th>Exam Form</th>
                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                            <?php
							$CI =& get_instance();
							$CI->load->model('Examination_model');
                            //echo "<pre>";
							print_r($ex_session);
							$role_id = $this->session->userdata('role_id');
                          $ex_session=explode('-',$ex_session);
						  $exam_id=$ex_session[2];
                            $j=1;  

                            if(isset($emp_list)){
								echo "<span style='color:red;'>Total Students:".count($emp_list)."</span>";
							}							
                            for($i=0;$i<count($emp_list);$i++)
                            {
                               //echo $emp_list[$i]['isPresent']; 
                            ?>
							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
							<th class="noExl"><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?=$emp_list[$i]['stud_id']?>"></th>
                              <td><?=$j?></td>
                        
                                 <td><?="'".$emp_list[$i]['enrollment_no']?></td> 
                                    <td>
							
							<?php
							//$examfees =$this->Examination_model->getExamappliedFess($emp_list[$i]['stud_id'], $emp_list[$i]['current_semester']);//check for attendance
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td>
								<td><?=$emp_list[$i]['mobile']?></td> 
								<td><?=$emp_list[$i]['stream_short_name']?></td> 
								<td><?=$emp_list[$i]['current_semester']?></td> 
								<td><?=$emp_list[$i]['fee']?></td> 
								<td><?php if($emp_list[$i]['fee'] !=0){ if(!empty($emp_list[$i]['fees'][0]['amount']))echo "<span style='color:green'>".$emp_list[$i]['fees'][0]['amount']."-Paid </span>";else{ echo "Not Paid";}}else echo '-';?></td>
								<td><?php if($emp_list[$i]['applicable_fee'][0]['applicable_fee'] !='')echo $emp_list[$i]['applicable_fee'][0]['applicable_fee'] - $emp_list[$i]['tot_fees_paid'][0]['tot_fee_paid']; else echo '-';?></td> 
								
								<td><?php if($emp_list[$i]['allow_for_exam']=='Y'){?> <button class="btn btn-success">Y</button><?php }else{?><button class="btn btn-danger">N</button><?php }?></td> 
                                                                                              
                          <td>
						  <?php if($role_id==15){ ?>
						  <a  href="<?php echo base_url()."examination/download_pdf/".base64_encode($emp_list[$i]['stud_id'])."/".$exam_id."/"?>" title="View" target="_blank"><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i> </a>
						  <?php }?>
						  </td> 
                            </tr>
                            <?php
							unset($avgper);
							unset($tot_avg);
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>  
					<div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_hold" type="submit" onclick="return validate_student(this.value)">Hold Exam</button> </div>
					<div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_approve" type="submit" onclick="return validate_student(this.value)">Allow Exam</button> </div>
                     <input type="button" id="expdata" value="Export as Excel" class="btn btn-primary btn-labeled">
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
	
		//Allocate batch
	$('#btn_hold').on('click', function () {
		//alert("hi");
			var chk_stud = $("#chk_stud").val();
			var school = $("#school").val();
			var course= $("#admission-course").val(); 
			var stream = $("#stream_id").val();
			var sem = $("#semester").val();
			var exam_session = $("#exam_session").val();
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
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Examination/hold_students',
					data: {chk_stud:chk_checked,school:school,admission_course:course,semester:sem,admission_stream:stream,exam_session:exam_session},
					success: function (data) {
						alert("Selected students exam is  HOLD successfully..");
						 location.reload();
						/*if(data!='dupyes'){
							var absent=JSON.parse(data);
							
							var allstud_list = absent.ss.length;
							//alert(allstud_list);							
							//console.log(data);
							var str="";
							var q=0;
							for(i=0;i< allstud_list;i++)
							{
								if(absent.ss[i].isPresent==0){
									var bt = "<button class='btn btn-danger'>N</button>";
								}else{
									var bt = "<button class='btn btn-success'>Y</button>";
								}
								
								if(absent.ss[i].allow_for_exam=='Y'){
									var alw_fr_exam = "<button class='btn btn-success'>Y</button>";
								}else{
									var alw_fr_exam = "<button class='btn btn-danger'>N</button>";
								}
							
								//alert(absent.ss[i].fees.length);
								if(absent.ss[i].fees.length > 0){
									var amount = absent.ss[i].fees[0].amount;
								}else{
										var amount = '-';
								}
								//var amount='-';
								str+='<tr>';
								str+='<td><input type="checkbox" name="chk_stud[]" id="chk_stud" class="studCheckBox" value="'+absent.ss[i].stud_id+'"></td>'; 
								str+='<td>'+(q+1)+'</td>';   
								str+='<td>'+absent.ss[i].enrollment_no+'</td>';
								str+='<td>'+absent.ss[i].first_name+' '+absent.ss[i].middle_name+' '+absent.ss[i].last_name+'</td>';
								str+='<td>'+absent.ss[i].admission_semester+'</td>';
								str+='<td>'+amount+'</td>';
								str+='<td>'+bt+'</td>';
								str+='<td>'+alw_fr_exam+'</td></tr>';
								$("#studtbl").html(str);
								q++;
								delete bt;
								delete alw_fr_exam;
								delete amount;
								//}
							}
							
							alert("Operation successful");
							
						}else{
							
						}*/
						
					}
				});
			} else {
				$('#studtbl').html('<option value="">No data found</option>');
			}
		});
		//
		$('#btn_approve').on('click', function () {
		//alert("hello");
			var chk_stud = $("#chk_stud").val();
			var school = $("#school").val();
			var course= $("#admission-course").val(); 
			var stream = $("#stream_id").val();
			var sem = $("#semester").val();
			var exam_session = $("#exam_session").val();
			var chk_checked = [];
            $.each($("input[name='chk_stud[]']:checked"), function(){            
                chk_checked.push($(this).val());
            });
			var arr_length = chk_checked.length;
			if(arr_length ==0){
				return false;
			}
			if (arr_length !=0) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Examination/approve_students',
					data: {chk_stud:chk_checked,school:school,admission_course:course,semester:sem,admission_stream:stream,exam_session:exam_session},
					success: function (data) {
						alert("Selected students exam is  ALLOWED  successfully..");
						 location.reload();
						/*if(data!='dupyes'){
							var absent=JSON.parse(data);
							//alert(absent);
							var allstud_list = absent.ss.length;
		
							//console.log(absent);
							//alert(allstud_list);
			
				
							var str="";
							var q=0;
							for(i=0;i< allstud_list;i++)
							{
								if(absent.ss[i].isPresent==0){
									var bt = "<button class='btn btn-danger'>N</button>";
								}else{
									var bt = "<button class='btn btn-success'>Y</button>";
								}
								
								if(absent.ss[i].allow_for_exam=='Y'){
									var alw_fr_exam = "<button class='btn btn-success'>Y</button>";
								}else{
									var alw_fr_exam = "<button class='btn btn-danger'>N</button>";
								}
								if(absent.ss[i].fees.length > 0){
									var amount = absent.ss[i].fees[0].amount;
								}else{
										var amount = '-';
								}
								str+='<tr>';
								str+='<td><input type="checkbox" name="chk_stud[]" id="chk_stud" class="studCheckBox" value="'+absent.ss[i].stud_id+'"></td>'; 
								str+='<td>'+(q+1)+'</td>';   
								str+='<td>'+absent.ss[i].enrollment_no+'</td>';
								str+='<td>'+absent.ss[i].first_name+' '+absent.ss[i].middle_name+' '+absent.ss[i].last_name+'</td>';
								str+='<td>'+absent.ss[i].admission_semester+'</td>';
								str+='<td>'+amount+'</td>';
								
								str+='<td>'+bt+'</td>';
								str+='<td>'+alw_fr_exam+'</td></tr>';
								$("#studtbl").html(str);
								
								q++;
								//}
							}
							
							alert("Operation approve successful");
							
						}else{
							
						}*/
						
					}
				});
			} else {
				$('#studtbl').html('<option value="">No data found</option>');
			}
		});
});	
$(document).ready(function() {
$("#expdata").click(function(){

  $("#table2excel").table2excel({

    exclude: ".noExl",	
    name: "EmailTracking",
   filename: "Exam_Applied_Student_List_<?=$exam_session[0]['exam_month']?>_<?=$exam_session[0]['exam_year']?>" //do not include extension

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