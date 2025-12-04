<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<script src="<?=base_url('assets/javascripts')?>/jquery.table2excel.js"></script>
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
			'url' : base_url + '/Phd_examination/load_streams',
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
		var admission_course = $("#admission-course").val();
		//alert(admission_course);
		if (admission_course) {
			$.ajax({
				type: 'POST',
				url: '<?= base_url() ?>Phd_examination/load_streams',
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
        <li class="active"><a href="#">Examination</a></li>
        <li class="active"><a href="#">Time Table</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Add Exam Time Table</h1>
            
        </div>
        
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title">
                            <form method="post">
                            <div class="form-group">
                             <!-- <label class="col-sm-2">Course<sup class="redasterik" style="color:red">*</sup></label>-->
							 <div class="col-sm-2" >
                                <select name="regulation" id="regulation" class="form-control" required>
                                  <option value="">Select Batch</option>
                                  <?php
                                    foreach ($batches as $reg) {
                                        if ($reg['batch'] == $_REQUEST['regulation']) {
                                            $sel = "selected";
                                        } else {
                                            $sel = '';
                                        }
                                        echo '<option value="' . $reg['batch'] . '"' . $sel . '>' . $reg['batch'] . '</option>';
                                    }
                                    ?>
                               </select>
                              </div>
							 <div class="col-sm-2">
                                <select name="exam_session" id="exam_session" class="form-control" required>
                                 <option value="">Exam Session</option>
                               
                                  <?php

foreach ($exam_session as $exsession) {
	$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
	$exam_sess_val = $exsession['exam_month'] .'-'.$exsession['exam_year'].'-'.$exsession['exam_id'];
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
                             
                            <!--  <label class="col-sm-2">Stream<sup class="redasterik" style="color:red">*</sup></label>-->
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
                                   <option value="5" <?php if($_REQUEST['semester'] ==5){ echo "selected";}else{}?>>5 </option>
								    <option value="6" <?php if($_REQUEST['semester'] ==6){ echo "selected";}else{}?>>6 </option>
									 <option value="7" <?php if($_REQUEST['semester'] ==7){ echo "selected";}else{}?>>7 </option>
									  <option value="8" <?php if($_REQUEST['semester'] ==8){ echo "selected";}else{}?>>8 </option>
                                  </select>
                             </div>
							 <br><br>
							 <div class="form-group pull-right" style="margin-right: 15px;">
							     <div class="col-sm-8" id="">
                                <select name="exam_type" id="exam_type" class="form-control" required>
                                  <option value="">Select Type</option>
                                   <option value="Reg" <?php if($_REQUEST['exam_type'] =='Reg'){ echo "selected";}else{}?>>Regular </option>
                                   <option value="bklg" <?php if($_REQUEST['exam_type'] =='bklg'){ echo "selected";}else{}?>>Backlog </option>
                                  </select>
                             </div>						
								<div class="col-sm-2">
								 <input type="submit" id="" class="btn btn-primary btn-labeled" value="Search" > 
								</div>
							</div>
                             <!--<div class="col-sm-3" id="semest">
                               <a href="<?=base_url()?>Ums_admission/generateallpdfs">  <input type="button" id="" class="btn btn-primary btn-labeled" value="Generate All" > </a>
                            </div>-->
                            </div>
							
                            </form>
                        </span>
                        <div class="holder1"></div>
                </div>

            <div class="table-info panel-body"  >  
			<?php 
			$role_id=$this->session->userdata('role_id');
			//if(isset($role_id) && $role_id==1 ){?>
            <form id="" method="post" action ="<?=base_url()?>phd_exam_timetable/insert_exam_timetable">

            <input type="hidden" name="stream_id" value="<?=$stream?>">
			<input type="hidden" name="adm_semester" value="<?=$semester?>">
				<?php// }?>
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" style="">    
				<?php 	
					if($_POST){
				
				?>	
							<input type="hidden" name="exam_id" id="exam_id" value="<?=$exam_id?>">
							<input type="hidden" name="exam_month" id="exam_month" value="<?=$exam_month?>">
							<input type="hidden" name="exam_year" id="exam_year" value="<?=$exam_year?>">	
<input type="hidden" name="batch" id="batch" value="<?=$batch?>">	
<input type="hidden" name="examtype" id="examtype" value="<?=$exam_type?>">
 <table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                   <!--th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th-->
                                    <th>S.No.</th>
									
                                    <th>Course Code</th>
                                    <th>Course Name</th>
                                     <th>Sem</th>
                                     <th>Date</th>
                                     <th>From Time</th>
                                    <th>To Time </th>
									<th>Display on HallTicket </th>
                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                            <?php
                            //echo "<pre>";
							//print_r($sub_list);
                          
                            $j=1;                            
                            for($i=0;$i<count($sub_list);$i++)
                            {
                               //echo $sub_list[$i]['isPresent']; 
							   if($sub_list[$i]['subject_component']=='TH'){
								   $required ='required';
							   }else{
								   $required ='';
							   }
                            ?>
							<input type="hidden" name="subject_id[]" id="subject_id<?=$j?>" class='studCheckBox' value="<?=$sub_list[$i]['sub_id']?>">
							<input type="hidden" name="subject_code[]" id="subject_code<?=$j?>" class='studCheckBox' value="<?=$sub_list[$i]['subject_code1']?>">
							
							
							 <?php if($sub_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$sub_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
							<!--th><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?=$sub_list[$i]['stud_id']?>"></th-->
                              <td><?=$j?></td>
                        
                                 <td><?=$sub_list[$i]['subject_code']?></td> 
                                    <td>
							
							<?php
								echo $sub_list[$i]['subject_name'];
								?>
								</td> 
								<td><?=$sub_list[$i]['semester']?></td> 
								<td><input type="text" name="exam_date[]" id="exam_date<?=$j?>" class="form-control" onclick="return getExamDate(this.id);" style="width: 110px;" <?=$required?>></td> 
								
								<td>
								<select name="from_time[]" id="" class="form-control">
									<option value="09:30:00" selected="selected">09:30</option>
									<option value="10:00:00" selected="selected">10:00</option>
									<option value="02:00:00">02:00</option>
									<!--option value="11:00:00">11:00</option>
									<option value="12:00:00">12:00</option>
									<option value="13:00:00">13:00</option>
									<option value="14:00:00">14:00</option>
									<option value="15:00:00">15:00</option>
									<option value="16:00:00">16:00</option>
									<option value="17:00:00">17:00</option>
									<option value="18:00:00">18:00</option-->
								</select>
								</td> 
                                <td>
								<select name="to_time[]" id="" class="form-control">
									<option value="12:30:00" selected="selected">12:30</option>
									<option value="01:00:00" selected="selected">01:00</option>
									<option value="05:00:00">05:00</option>
									<!--option value="11:00:00">11:00</option>
									<option value="12:00:00" selected="selected">12:00</option>
									<option value="13:00:00">13:00</option>
									<option value="14:00:00">14:00</option>
									<option value="15:00:00">15:00</option>
									<option value="16:00:00">16:00</option>
									<option value="17:00:00">17:00</option>
									<option value="18:00:00">18:00</option-->
								</select>
								</td>                                                          
								<td style="width: 90px;"><input type="checkbox" name="display_on_hallticket[]" id="display_on_hallticket" value="<?=$sub_list[$i]['sub_id']?>" checked></td> 	
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>  
					<div class="col-sm-5"></div>
					<div class="col-sm-2"> <button class="btn btn-primary form-control" id="submit" type="submit" >Submit </button> </div>
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
	
		//Allocate batch
	$('#btn_hold').on('click', function () {
		//alert("hi");
			var chk_stud = $("#chk_stud").val();
			var school = $("#school").val();
			var course= $("#admission-course").val(); 
			var stream = $("#stream_id").val();
			var sem = $("#semester").val();
	
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
					url: '<?= base_url() ?>Phd_examination/hold_students',
					data: {chk_stud:chk_checked,school:school,admission_course:course,semester:sem,admission_stream:stream},
					success: function (data) {
						//alert(data);
						if(data!='dupyes'){
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
							
						}
						
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
					url: '<?= base_url() ?>Phd_examination/approve_students',
					data: {chk_stud:chk_checked,school:school,admission_course:course,semester:sem,admission_stream:stream},
					success: function (data) {
						//alert(data);
						if(data!='dupyes'){
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
							
						}
						
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