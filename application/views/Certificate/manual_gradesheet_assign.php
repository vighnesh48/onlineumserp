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
      'url' : base_url + '/Certificate/load_edstreams',
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
    var school_code = $("#school_code").val();    
    var admission_course = $("#admission_course").val();
    var ex_ses = $("#exam_session").val(); 
    
    $("#admissioncourse").val($("#admission_course option:selected" ).text());
    //alert(admission_course);
    if (admission_course) {
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>Certificate/load_edstreams',
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
           // $("#stream_id option[value='" + stream_id1 + "']").attr("selected", "selected");
          }
        });
      } else {
        //$('#semester').html('<option value="">Select Stream first</option>');
                $('#semester').val('');
            $('#ressemester').val('');
      }
  // edit
var admission_course = '<?=$admissioncourse?>';
var school_code = '<?=$school_code?>';    
var ex_ses = '<?=$exam?>'; 

    if (admission_course) {
		
      $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>Certificate/load_edstreams',
        data: {course_id:admission_course,ex_ses:ex_ses,school_code:school_code},
        success: function (html) {
          // alert(html);
          var stream_id = '<?=$stream?>';
		  console.log(stream_id);
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
        <li class="active"><a href="#">Results</a></li>
    </ul>
    <div class="page-header" id="page-header">
      <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Consolidated Dispatch</h1>
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
               <form method="post" action="<?=base_url()?>Certificate/gradesheet_dispatch" name="dispatch" id="dispatch">  
                            <div class="form-group">
               <div class="col-sm-2" >
                                <select name="regulation" id="regulation" class="form-control" required>
                                  <option value="">Select Regulation</option>
                                  <?php 
								  if($_REQUEST['regulation']){
									   $res=$_REQUEST['regulation'];
								  }else{
									   $res=$regulation;
								  }
								  
                                    foreach ($regulatn as $reg) {
                                       if($reg['regulation']=='2016'){}else{
                                        if ($reg['regulation'] == $res) {
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
					if($_REQUEST['exam_session']){
						$ex_session=$_REQUEST['exam_session'];
					}else{
					    $ex_session=$e_session;
					}
					
                      if ($exam_sess == $ex_session) {
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
                                
                                <!-- <option value="0">All School</option>-->
                                                    <?php
                  foreach ($schools as $sch) {
                      if($school_code){
						  $school_codee=$school_code;
					  }else{
						  $school_codee=$school_segment;
					  }
					  if ($sch['school_code'] == $school_codee) {
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

                              <div class="col-sm-2" id="semest">
                                <select name="admission_branch" id="stream_id" class="form-control">
                                  <option value="">Select Stream</option>
                                  </select>
                                   <input type="hidden" name="admissionbranch" id="admissionbranch" value="<?php echo $_REQUEST['admissionbranch'] ?>" />
                              </div>
                              <div class="col-sm-2" id="">
                             <input type="hidden" name="semester" id="semester" value="" class="form-control" />
                                <!--<select name="semester" id="semester" class="form-control" required>
                                  <option value="">Select Semester</option>
                                   <option value="1" <?php //if($_REQUEST['semester'] ==1){ echo "selected";}else{}?>>1 </option>
                                   <option value="2" <?php //if($_REQUEST['semester'] ==2){ echo "selected";}else{}?>>2 </option>
                                   <option value="3" <?php //if($_REQUEST['semester'] ==3){ echo "selected";}else{}?>>3 </option>
                                   <option value="4" <?php //if($_REQUEST['semester'] ==4){ echo "selected";}else{}?>>4 </option>
                                  </select>-->
                             </div><br><br>
                              <div class="col-sm-2 pull-right" id="semest">
                                 <input type="submit" id="" class="btn btn-primary btn-labeled pull-right" value="Search" > 
                            </div>
                            </div>
                            </form>
                        </span>
                        <div class="holder1"></div>
                </div>
      
            <div class="table-info panel-body" style="">  
      <?php 
      $role_id=$this->session->userdata('role_id');
      //if(isset($role_id) && $role_id==1 ){overflow-x:scroll;height:500px; overflow-y:scroll;width:100%;?>
          

            
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
                    <div class="row" style="color:green;margin-left:15px;margin-bottom:5px;" >
                   <b class="msgt"><?php if(!empty($this->session->flashdata('mskrd'))){ echo $this->session->flashdata('mskrd');}?>  </b>                  
                    <hr class="visible-xs no-grid-gutter-h">
                </div>    
        <?php   
          if(!empty($stud_list)){
        
        ?>
        <form name="mrkcrdfrom" id="mrkcrdfrom" method="post" action="<?=base_url()?>Certificate/gradesheet_dispatch_insert">
               <!-- <input type="hidden" name="stud_prn[]" id='stud_prn' value=""> -->
                <div class="row">
      <div class="col-lg-3"><!--<input type="text" name="current_date" value="" id="datepicker" class="form-control">-->
      </div>
                        <div class="col-lg-2">
                        <?php //if($this->session->userdata("uid")==2){?>
                       <!-- <input type="button" name="generate" value="Pdf" id="pdfcard1" class="btn btn-primary">-->
                        <?php //} ?>
                        </div>
                    </div>
                     <div class="row">&nbsp;&nbsp;
                     <input type="hidden" name="gc_id" id="gc_id" value="<?=$gc_id?>">
                     <input type="hidden" name="semester" id="ressemester" value="<?=$semester?>">
                     <input type="hidden" name="school" value="<?=$school_code?>">
                     <input type="hidden" name="stream_id" id='resstream_id' value="<?=$stream?>">
                     <input type="hidden" name="exam_id" id='resstream_id' value="<?=$exam_id?>">
                     <input type="hidden" name="regulation_id" id='regulation_id' value="<?=$regulation?>">
                     <input type="hidden" name="exam_session" id="resexam_session" value="<?=$exam_month.'~'.$exam_year.'~'.$exam_id?>">
                         <?php $result_data = $stream.'~'.$semester.'~'.$exam_id.'~'.$exam_year.'~'.$exam_month; ?>
                            <input type="hidden" id="res_data" name="res_data" value="<?=$result_data?>">
                     <br /></div>
<!--        <table class="table table-bordered nowrap" id="table2excel">
-->               <table id="table2excel" class="display nowrap" style="width:100%">
                         
              
                        <thead>
                                  <!--<tr> <th>&nbsp;</th>
<th colspan="1">Regulation:</th>                  
<th colspan="1">Year&nbsp;of&nbsp;Passing</th>
<th colspan="1">School&nbsp;Name</th>
<th colspan="1">Course</th>
<th colspan="1">Stream</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
                                    <th>&nbsp;</th>
</tr>-->
<!--<tr><td>&nbsp;</td>
<td colspan="1"><?php ////print_r($regulation);?></td>                  
<td colspan="1"><?php //print_r($exam_new);?></td>
<td colspan="1"><?php //print_r($schoolname_new);?></td>
<td colspan="1"><?php // print_r($admissioncourse_new);?></td>
<td colspan="1"><?php //print_r($admissionbranch_new);?></td>
<td>&nbsp;</td>
<td>&nbsp;</td>
<td>&nbsp;</td>
</tr>-->

 
                             
                            <tr>
                                   <th class="noExl"><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th>
                                    <th>S.No.</th>
                  
                                    <th>PRN</th>
                                    <th>Student Name</th>
                                    <!--<th>Photo</th>
                  <th>Classification</th>-->
                                    <th>CGPA</th>
                                   <!-- <th>Session</th>-->
                                    <th>Attempt</th>
                                    <th>Action</th>
                                    

                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                          
                            <?php
                            //echo "<pre>";
              //print_r($stud_list);
                          $CI =& get_instance();
						  $CI->load->model('Results_model');
                            $j=1;  $Honours='0'; $Distinction='0';  $FirstClass='0';     $SecondClass='0';   $ThirdClass='0';       
                            $exam_month = str_replace('/','_',$exam_month);

                            for($i=0;$i<count($stud_list);$i++)
                            {
								if(!empty($stud_list[$i]['Result'])){
									
									$res_uniq_sem = $this->Results_model->fetch_student_unique_result_semester($stud_list[$i]['stud_id'],$stud_list[$i]['exam_id']);
									$res_uniq_subjects = $this->Results_model->fetch_student_subject_completion($stud_list[$i]['stud_id']);
									
									if($stud_list[$i]['admission_year']==1){
										$s=1;
									}else if($stud_list[$i]['admission_year']==2){
										$s=3;
									}else if($stud_list[$i]['admission_year']==3){
										$s=5;
									}

									for ($x = $s; $x <= $stud_list[$i]['current_semester']; $x++) {
										$studallsem[]=$x;
									}
									foreach($res_uniq_sem as $rsem){
									 $res_uniq_sems[] = $rsem['semester'];  
									}	
									
									$uniq_sems=array_diff($studallsem,$res_uniq_sems);
									// echo '<pre>';
									// echo 'gfg';print_r($studallsem);echo '<br>';print_r($res_uniq_sems);echo '<br>';print_r($uniq_sems);
									// echo $stud_list[$i]['enrollment_no'];
									// print_r($uniq_sems);
									/*if($stud_list[$i]['enrollment_no']=='170101062100'){
										echo 'gfg';print_r($studallsem);echo '<br>';print_r($res_uniq_sems);echo '<br>';print_r($uniq_sems);exit;
									}*/
									if(empty($uniq_sems) && empty($res_uniq_subjects)){
                            ?>
  
               
                            <tr>
            <td class="noExl">
                            <input type="hidden" name="stream_idn[<?=$i?>]" id='resstream_id' value="<?=$stud_list[$i]['stream_id']?>">
                            <input type="hidden" name="exam_idn[<?=$i?>]" id='resstream_id' value="<?=$stud_list[$i]['exam_id']?>">
                           <!-- <input type="hidden" name="stud_prnn[]" id='stud_prnn' value="<?=$stud_list[$i]['enrollment_no']?>"> 
                             <input type="hidden" name="stud_idd[]" id='stud_idd' value="<?=$stud_list[$i]['enrollment_no']?>">
                             -->
                             <input type="hidden" name="schoold[<?=$i?>]" id='schoold' value="<?=$stud_list[$i]['school_code']?>">

                      <input type="checkbox" name="chk_stud[<?=$i?>]" id="chk_stud_<?=$j?>" class='studCheckBox' value="<?=$stud_list[$i]['stud_id']?>" disabled>
                      <input type="hidden" name="stud_prn[<?=$i?>]" id="prn_<?=$j?>" style="width:30px" value="<?=$stud_list[$i]['enrollment_no']?>" disabled>
                            </td>
                              <td><?=$j?></td>
                            <!--input type="hidden" name="stud_prn[]" style="width:30px" value="<?=$stud_list[$i]['enrollment_no']?>">
                            <input type="hidden" name="stud_id[]" style="width:30px" value="<?=$stud_list[$i]['student_id']?>"-->
                                <td><?=$stud_list[$i]['enrollment_no']?></td> 
                                <td><?=$stud_list[$i]['stud_name'];?></td>  
                                <!-- td><img src="<?php // base_url()?>uploads/student_photo/<?=$stud_list[$i]['enrollment_no']?>.jpg" alt="<?=$stud_list[$i]['student_id']?>" width="50" ></td -->
              
                                
                                <td><?=$stud_list[$i]['cumulative_gpa'];?></td>
                                <td><?php if($stud_list[$i]['checb']==0){ echo 'First Attempt'; }else{ echo '-';} ?></td>
                               
                              <td>  <input type="text" id="mrk_<?=$j?>" name="markscardno[<?=$i?>]" value="<?=$stud_list[$i]['markscard_no']?>" class="form-control" style="width: 100px;" disabled> </td>               
                            </tr>
                            <?php
                            $j++;
							unset($uniq_sems);
							unset($studallsem);
							unset($res_uniq_sems);
									}
								}
							}
                            ?>  
                        
                       
                     


</tbody> 
</table>
 <ul class="nav nav-tabs">
          <li class="active"><a data-toggle="tab" href="#menu1">Assign Consolidated Dispatch No </a></li>
          <li><a data-toggle="tab" href="#menu2">Dispatch Report</a></li>
          <!--<li><a data-toggle="tab" href="#menu3">Ladger Report</a></li>-->
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
                        <td>Consolidated Dispatch No Start From </td>
                        <td><input type="text" name="mrkcrdno" id="mrkcrdno" maxlength="7" class="numbersOnly"></td>
                        
                        <td colspan=2><input type="button" name="assign" id="assignmcn" class="btn btn-primary" value="Assign">&nbsp;&nbsp;
                          <input type="button" name="generate" value="Save Dispatch" id="gmarkscard1" class="btn btn-primary" onclick="return validate_student(this.value)">
            
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
  //  alert(admission_branch);
    /*$.ajax({
        type: 'POST',
        url: '<?= base_url() ?>Certificate/Manual_excel/',
        data: {regulation:regulation,exam_session:exam_session,school_code:school_code,
      admission_course:admission_course,stream_id:stream_id,admissionbranch:admissionbranch,
      semester:semester,schoolname:schoolname,admissioncourse:admissioncourse,
      admission_branch:admission_branch},
        success: function (html) {
          //alert(html);
          //var course_id = '<>';
          //$('#admission-course').html(html);
          //$("#admission-course option[value='" + course_id + "']").attr("selected", "selected");
        }
      });
    */
    
    
    
  });
  
  
   $("#pdfcard1").on('click', function () {
    var datepicker=$("#datepicker").val();
    if(datepicker==""){
$("#datepicker").css('border-color', 'red');
            $("#datepicker").focus();
      return false;
    }else{$("#datepicker").css('border-color', '');}
    //$("#regulationex").val($("#regulation").val());
    //$("#exam_sessionex").val($("#exam_session").val());
    //$("#school_codeex").val($("#school_code").val());
    //$("#admission_courseex").val($("#admission_course").val());
    //$("#stream_idex").val($("#stream_id").val());
    //$("#admissionbranchex").val($("#admissionbranch").val());
    //$("#semesterex").val($("#semester").val());
    //$("#schoolnameex").val($("#schoolname").val());
    //$("#admissioncourseex").val($("#admissioncourse").val());
    //$("#admission_branchex").val($("#stream_id").val());
    //var values = $("input[name='stud_prnn[]']")
          //    .map(function(){return $(this).val();}).get();
        
      //  $("#stud_prn").val(values);
    $("#mrkcrdfrom").attr("action",'<?=base_url()?>Certificate/Manual_certificate_All');
    $("#mrkcrdfrom").trigger("submit");
  //  alert(admission_branch);
    /*$.ajax({
        type: 'POST',
        url: '<?= base_url() ?>Certificate/Manual_excel/',
        data: {regulation:regulation,exam_session:exam_session,school_code:school_code,
      admission_course:admission_course,stream_id:stream_id,admissionbranch:admissionbranch,
      semester:semester,schoolname:schoolname,admissioncourse:admissioncourse,
      admission_branch:admission_branch},
        success: function (html) {
          //alert(html);
          //var course_id = '<>';
          //$('#admission-course').html(html);
          //$("#admission-course option[value='" + course_id + "']").attr("selected", "selected");
        }
      });
    */
    
    
    
  });

  
$(document).ready(function() {
  
     
  $('#datepicker').datepicker({
        "setDate": new Date(),
        "autoclose": true
});
  
  
   /* $('#table2excel').DataTable( {
       // dom: 'Bfrtip',
        buttons: [
           'excel', 'pdf'
        ]
    } );*/
  
   $('#table2excel').DataTable( {
        dom: 'Bfrtip',
         targets: 'no-sort',
       bSort: false,
     "bPaginate": false,
        buttons: [
         /*   {
                extend: '', //excelHtml5
                title: 'Provisional Certificate list',
        exportOptions: {
          
                columns: [1,2,3,4,5,6,7]
            }
            },*/
           /* {
               extend: 'pdfHtml5', //pdfHtml5
       customize: function(doc) {

       //ensure doc.images exists
       doc.images = doc.images || {};
      // var myGlyph=
        //build dictionary
      //  doc.images['myGlyph'] = getBase64Image(myGlyph);
        //..add more images[xyz]=anotherDataUrl here

        //when the content is <img src="myglyph.png">
        //remove the text node and insert an image node
        for (var i=1;i<doc.content[1].table.body.length;i++) {
      //console.log(doc.content[1].table.body[i][3].text);
      
          //  if (doc.content[1].table.body[i][0].text == '<img src="myglyph.png">') {
           //     delete doc.content[1].table.body[i][0].text;
           //     doc.content[1].table.body[i][0].image = 'myGlyph';
           // }
        }
    
    for (var i = 1; i < doc.content[1].table.body.length; i++) {
    if (doc.content[1].table.body[i][3].text.indexOf('<img src=') !== -1) {
        html = doc.content[1].table.body[i][3].text;

        var regex = /<img.*?src=['"](.*?)['"]/;
        var src = regex.exec(html)[1];


        var tempImage = new Image();
        tempImage.src = src;
var t=getBase64Image(tempImage);
//console.log(t);
         doc.images[src] = getBase64Image(tempImage);

        delete doc.content[1].table.body[i][3].text;
        doc.content[1].table.body[i][3].image = src;
        doc.content[1].table.body[i][3].fit = [50, 50];
    }

    //here i am removing the html links so that i can use stripHtml: true,
  // if (doc.content[1].table.body[i][3].text.indexOf('<a href="details.php?') !== -1) {
      //  html = $.parseHTML(doc.content[1].table.body[i][3].text);
      //  delete doc.content[1].table.body[i][3].text;
      //  doc.content[1].table.body[i][3].text = html[0].innerHTML;
   // }

}
    
    
    
    },
                title: 'Provisional Certificate list',
        exportOptions: {
           stripHtml: false,
                 columns: [1,2,3,4,5,6,7]
      
      
      
      
                 }
            }*/
      
        ]
    
    } );
  
  
  
} );
</script>
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
   var array=[]
  $('.studCheckBox:checkbox:checked').map(function() {
	// array.push();
	var sid=this.id.substring(this.id.lastIndexOf("_") + 1);
	array.push($("#mrk_"+sid).val());
	
	//alert($("#mrk_1").val());
    //alert($("#"+sid)).val();
}).get();
  

      var frmserno = $("#frmserno").val();
      var toserno = $("#toserno").val();
      var mrkcrd_no = $("#mrkcrdno").val();
      var range_cnt = toserno - frmserno;
      //alert(array);
      if(frmserno !='' && toserno !='' && mrkcrd_no !=''){
		  //alert(frmserno+"/"+toserno)
		  if(frmserno==0){
			  alert("From S.No Cannot be 0");
		  }
		  else if(toserno==0){
			 alert("To S.No Cannot be 0"); 
		  }
		 else if(parseInt(frmserno) > parseInt(toserno)){
			 alert("From S.No Cannot be greater than To S.No"); 
		  }
		  else{
        var s=0;
		  for (var i = 0; i <= range_cnt; i++) {
			
         
      if(array.includes(mrkcrd_no)==true){
         s=1;
        alert("These series is already assigned");
        break;
       
      }
        else{
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
		  }
      
      if(s==0){
		  alert("Consolidated Dispatch No Assigned Successfully.");
		  }
	  }
    }else{
      alert("Please enter all input fields.");
    }
    
  });
  //dispatch report
    $('#emdsexcl').on('click', function () {  

    var res_data = $("#res_data").val();
    // alert(res_data);
    if (res_data) {
      window.location.href = '<?= base_url() ?>Certificate/download_mrksno_dispatch_report/'+res_data;
    } else {
      
    }
  });
  //lazar report
    $('#emlsexcl').on('click', function () {  
    var res_data = $("#res_data").val();
    if (res_data) {
      window.location.href = '<?= base_url() ?>Certificate/lazar_report/'+res_data;
    } else {
      
    }
  }); 

}); 
Number.prototype.pad = function(size) {
  var s = String(this);
  while (s.length < (size || 2)) {s = "0" + s;}
  return s;
}


$(document).ready(function(){
var form=$("#mrkcrdfrom");
$("#gmarkscard1").click(function(){
$.ajax({
        type:"POST",
        url:form.attr("action"),
        data:form.serialize(),

        success: function(response){
        if(response ==="1"){
            $('.msgt').html('Dispatch No Assigned Successfully');  
			  //$('#stddata').focus();

        }  else {
			 $('.msgt').html('dispatch Not Assigned Successfully');
			  // $('#stddata').focus();

            //show error
        }
		var scrollPos =  $("#page-header").offset().top;
 $(window).scrollTop(scrollPos);
        }
    });
});
});
</script>