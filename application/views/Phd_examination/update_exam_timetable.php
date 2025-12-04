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
function changeValue(id){

	if ($('input:checkbox[id='+id+']').is(':checked')) 
	{
		$('#'+id).val('Y');
	}
	else
	{
		$('#'+id).val('N');
	}
	
}
function getExamDate(id){
	//alert(id);
	
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Update Exam Time table</h1>
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
                                    for($i=0;$i<count($ex_dt);$i++)
                                    {
                                ?>
                                <option value="<?=$ex_dt[$i]['emp_id']?>"><?=$ex_dt[$i]['fname'].' '.$ex_dt[$i]['lname']?></option>
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
								   <option value="6" <?php if($_REQUEST['semester'] ==6){ echo "selected";}else{}?>>6</option>
								   <option value="7" <?php if($_REQUEST['semester'] ==7){ echo "selected";}else{}?>>7</option>
								   <option value="8" <?php if($_REQUEST['semester'] ==8){ echo "selected";}else{}?>>8</option>
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
								<div class="col-sm-2" >
								 <input type="submit" id="" class="btn btn-primary btn-labeled " value="Search" > 
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

            <div class="table-info panel-body"  style="overflow:scroll;height:800px;">  
			<?php 
			$role_id=$this->session->userdata('role_id');
			//if(isset($role_id) && $role_id==1 ){?>
                     
			
				<?php// }?>
			
                <div class="col-lg-12">
                    <div class="table-info" id="stddata" style="<?=$tbstyle?>">    
				<?php 	
					if($_POST){
				
				?>
<input type="hidden" name="exam_id" id="exam_id" value="<?=$exam_id?>">			
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
                                    <th>Display on HallTicket</th>
									<th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                            <?php
                            //echo "<pre>";
							//print_r($ex_dt);
                          
                            $j=1;                            
                            for($i=0;$i<count($ex_dt);$i++)
                            {
                               //echo $ex_dt[$i]['isPresent']; 
                            ?>
							<input type="hidden" name="time_table_id" id="time_table_id<?=$j?>" value="<?=$ex_dt[$i]['time_table_id']?>">
							<input type="hidden" name="subject_id[]" id="subject_id<?=$j?>" class='studCheckBox' value="<?=$ex_dt[$i]['sub_id']?>">
							<input type="hidden" name="subject_code[]" id="subject_code<?=$j?>" class='studCheckBox' value="<?=$ex_dt[$i]['subject_code']?>">
							 <?php if($ex_dt[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$ex_dt[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
							<!--th><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?=$ex_dt[$i]['stud_id']?>"></th-->
                              <td><?=$j?></td>
                        
                                 <td><?=$ex_dt[$i]['subject_code']?></td> 
                                    <td>

								<?=$ex_dt[$i]['subject_name']?>
								</td> 
								<td><?=$ex_dt[$i]['semester']?></td> 
								<td><input type="text" name="exam_date[]" id="exam_date<?=$j?>" value="<?php if($ex_dt[$i]['date'] !='0000-00-00'){ echo date('d/m/Y', strtotime($ex_dt[$i]['date']));}?>" class="form-control" onclick="return getExamDate(this.id);" style="width: 110px;"></td> 
								
								<td>
								<select name="from_time[]" id="from_time<?=$j?>" class="form-control">
									<option value="09:30:00" <?php if($ex_dt[$i]['from_time']=='09:30:00'){ echo "selected";}?>>09:30</option>
									<option value="10:00:00" <?php if($ex_dt[$i]['from_time']=='10:00:00'){ echo "selected";}?>>10:00</option>
									<option value="02:00:00" <?php if($ex_dt[$i]['from_time']=='02:00:00'){ echo "selected";}?>>02:00</option>
									<!--option value="11:00:00" <?php if($ex_dt[$i]['from_time']=='11:00:00'){ echo "selected";}?>>11:00</option>
									<option value="12:00:00" <?php if($ex_dt[$i]['from_time']=='12:00:00'){ echo "selected";}?>>12:00</option>
									<option value="13:00:00" <?php if($ex_dt[$i]['from_time']=='13:00:00'){ echo "selected";}?>>13:00</option>
									<option value="14:00:00" <?php if($ex_dt[$i]['from_time']=='14:00:00'){ echo "selected";}?>>14:00</option>
									<option value="15:00:00" <?php if($ex_dt[$i]['from_time']=='15:00:00'){ echo "selected";}?>>15:00</option>
									<option value="16:00:00" <?php if($ex_dt[$i]['from_time']=='16:00:00'){ echo "selected";}?>>16:00</option>
									<option value="17:00:00" <?php if($ex_dt[$i]['from_time']=='17:00:00'){ echo "selected";}?>>17:00</option>
									<option value="18:00:00" <?php if($ex_dt[$i]['from_time']=='18:00:00'){ echo "selected";}?>>18:00</option-->
								</select>
								</td> 
                                <td>
								<select name="to_time[]" id="to_time<?=$j?>" class="form-control">
									<option value="12:30:00" <?php if($ex_dt[$i]['to_time']=='12:30:00'){ echo "selected";}?>>12:30</option>
									<option value="01:00:00" <?php if($ex_dt[$i]['to_time']=='01:00:00'){ echo "selected";}?>>01:00</option>
									<option value="05:00:00" <?php if($ex_dt[$i]['to_time']=='05:00:00'){ echo "selected";}?>>05:00</option>
									<!--option value="12:00:00" <?php if($ex_dt[$i]['to_time']=='12:00:00'){ echo "selected";}?>>12:00</option>
									<option value="13:00:00" <?php if($ex_dt[$i]['to_time']=='13:00:00'){ echo "selected";}?>>13:00</option>
									<option value="14:00:00" <?php if($ex_dt[$i]['to_time']=='14:00:00'){ echo "selected";}?>>14:00</option>
									<option value="15:00:00" <?php if($ex_dt[$i]['to_time']=='15:00:00'){ echo "selected";}?>>15:00</option>
									<option value="16:00:00" <?php if($ex_dt[$i]['to_time']=='16:00:00'){ echo "selected";}?>>16:00</option>
									<option value="17:00:00" <?php if($ex_dt[$i]['to_time']=='17:00:00'){ echo "selected";}?>>17:00</option>
									<option value="18:00:00" <?php if($ex_dt[$i]['to_time']=='18:00:00'){ echo "selected";}?>>18:00</option-->
								</select>
								</td>  
								<td style="width:90px;"><input type="checkbox" name="display_on_hallticket[]" id="ht<?=$j?>" value="Y" <?php if($ex_dt[$i]['display_on_hallticket']=='Y'){ echo "checked";}?>  onclick="return changeValue(this.id);">
								</td>
								<td>
								<a class="updateStat" id="<?=$j?>" data-toggle="modal" data-target="#appStatusModal" style="cursor:pointer"><button class="btn btn-primary form-control btn-xs">Update</button></a>
								</td>
																
                          
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>  
					<!--a href="<?=base_url($currentModule.'/generetPdf')?>/<?=$stream?>/<?=$semester?>/<?=$exam_month?>/<?=$exam_year?>"><button class="btn btn-primary">Download PDF</button></a>
					<div class="col-sm-2"-->  </div>
					
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
function updateTimetable(id){
	//alert(id);
	$('#'+id).focus();
	$('#'+id).datepicker( {format: 'dd/mm/yyyy',autoclose: true});
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
	// update admission status.
$(".updateStat").each(function () {
    $(document).on("click", '#' + this.id, function () {

	var exam_date = $('#exam_date'+this.id).val();
		var from_time = $('#from_time'+this.id).val();
		var time_table_id = $('#time_table_id'+this.id).val();
		var to_time= $('#to_time'+this.id).val();
		var ht= $('#ht'+this.id).val();
		var stream = $("#stream_id").val();
		var sem = $("#semester").val();
		var exam_id = $("#exam_id").val();
		//alert(exam_id);
		$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Phd_exam_timetable/update_exam_timetable',
					data: {time_table_id:time_table_id,from_time:from_time,to_time:to_time,semester:sem,admission_stream:stream,exam_date:exam_date,ht:ht,exam_id:exam_id},
					success: function (data) {
						alert("updated successfully");
						 location.reload();
					}
				});

    });
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