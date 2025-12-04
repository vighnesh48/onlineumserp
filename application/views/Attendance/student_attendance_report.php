<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<script src="<?=site_url()?>assets/javascripts/bootstrapValidator.js" type="text/javascript"></script>
<style type="text/css">.loader {
  border: 6px;
  border-radius: 50%;
  border-top: 6px solid pink;
  border-bottom: 6px solid pink;
  width: 90px;
  height: 90px;
  -webkit-animation: spin 2s linear infinite;
  animation: spin 2s linear infinite;
  margin-left:50%;
}
@-webkit-keyframes spin {
  0% { -webkit-transform: rotate(0deg); }
  100% { -webkit-transform: rotate(360deg); }
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
<script>    
    $(document).ready(function()
    {
       
  //       $('#academic_year').on('change', function () {
		// 	//alert("dfdsf");
		// 	var academic_year = $(this).val();
		// 	if (academic_year) {
		// 		$.ajax({
		// 			type: 'POST',
		// 			url: '<?= base_url() ?>Attendance/load_lecture_cources',
		// 			data: {academic_year:academic_year},
		// 			success: function (html) {
		// 				//alert(html);
		// 				$('#course_id').html(html);
		// 				//alert('hh');
		// 		$('#course_id option[value=""]').text('Select All Course');
		// 			}
		// 		});
		// 	} else {
		// 		$('#course_id').html('<option value="">Select academic year first</option>');
		// 	}
		// });
		      $('#sch_list').on('change', function () {
			//alert("dfdsf");
			var sch_list = $(this).val();
			var academic_year =$('#academic_year').val();
			if (sch_list) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Student_attendance/load_lecture_cources',
					data: {sch_list:sch_list,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#course_id').html(html);
						//alert('hh');
				$('#course_id option[value=""]').text('Select All Course');
					}
				});
			} else {
				$('#course_id').html('<option value="">Select academic year first</option>');
			}
		});
		
		$('#course_id').on('change', function () {
			var course_id = $(this).val();
			var academic_year =$("#academic_year").val();
			var sch_id=$('#sch_list').val();
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Student_attendance/load_streams',
					data: {course_id:course_id,academic_year:academic_year,sch_id:sch_id},
					success: function (html) {
						//alert(html);

						$('#stream_id').html(html);
						$('#stream_id option[value=""]').text('Select All Stream');
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		// load div from semester
		$('#stream_id').on('change', function () {
			var stream_id = $(this).val();
			var academic_year =$("#academic_year").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Attendance/getSemfromAttendance',
					data: {stream_id:stream_id,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#semester').html(html);
						$('#semester option[value=""]').text('Select All Semester');
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		});
		// load div from semester
		$("#semester").change(function(){
			var room_no = $("#stream_id").val();
			var semesterId = $("#semester").val();
			var academic_year =$("#academic_year").val();
			$.ajax({
				'url' : base_url + 'Attendance/load_division_by_acdmicyear',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : room_no,'semesterId':semesterId,academic_year:academic_year},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#division'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						container.html(data);
						$('#division option[value=""]').text('Select All Division');
						//$("#semest option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		});	
		$('#dt-datepicker').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
    });

</script>
<style>
.absent_bg{background:#ff9b9b;}
</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Lecture</a></li>
        <li class="active"><a href="#">Attendance</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Student Attendance Report</h1>
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
                            <span class="panel-title">Select Following Parameters</span>
                    </div>
                    <div class="panel-body">
                        <div class="table-info">                            
                           	<div class="form-group">
								<div class="col-sm-2" >
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year</option>
                                  <?php
									foreach ($academic_year as $yr) {
										if ($yr['academic_year'].'~'.$yr['academic_session'] == $academicyear) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session'].'"' . $sel . '>' . $yr['academic_year'].' ('.$yr['academic_session'] . ')</option>';
									}

									?>
									<!--option value="2022-23~WINTER">2022-23(WINTER)</option--> 
                               </select>
                              </div>
                              								<div class="col-sm-2" >
                                <select name="sch_list" id="sch_list" class="form-control" required>
                                  <option value="">Select School</option>
                                  <?php
									foreach ($school_list as $sch) {
										
										echo '<option value="' . $sch['school_code'].'">' . $sch['school_short_name'].'</option>';
									}

									?>
									<!-- <option value="2018-19~SUMMER">2018-19(SUMMER)</option> -->
                               </select>
                              </div>
								<div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" required>
                                  <option value="">Select Course</option>
                               
                               </select>
                              </div> 
                              <div class="col-sm-2" >
                                <select name="stream_id" id="stream_id" class="form-control" required>
                                  <option value="">Select Stream</option>
                               </select>
                              </div>							
								
						
                              <div class="col-sm-2" >
                                <select name="semester" id="semester" class="form-control" required>
                                  <option value="">Select Semester</option>
                               </select>
                              </div> 
                              <div class="col-sm-2" >
                                <select name="division" id="division" class="form-control" required>
                                  <option value="">Select  Division</option>
                               </select>
                              </div>
                              </div>
                                	<div class="form-group">
							            <div class="col-sm-2" >
                               <input type="text" class="form-control" name="from_date" id="dt-datepicker1" value="<?php echo  date( 'Y-m-d', strtotime( 'monday this week' ) ); ?>" placeholder="From Date" required>
                              </div>
                              <div class="col-sm-2" >
                              <input type="text" class="form-control" name="to_date" id="dt-datepicker2" value="<?php echo date( 'Y-m-d', strtotime( 'saturday this week' ) ); ?>"  placeholder="To Date" required>
                              </div>        
                                 <div class="col-sm-2" >
                               <select name="per_frm" id="per_from" class="form-control" >
                                  <option value="">Select From Percentange</option>
								  <option value="0">0%</option>
                                  <option value="10">10%</option>
                                  <option value="20">20%</option>
                                  <option value="30">30%</option>
                                  <option value="40">40%</option>
                                  <option value="50">50%</option>
                                  <option value="60">60%</option>
                                  <option value="70">70%</option>
                                  <option value="80">80%</option>
                                   <option value="90">90%</option>
                                  <option value="100">100%</option>
                               </select></div>
                              <div class="col-sm-2" >
                               <select name="per_to" id="per_to" class="form-control" >
                                  <option value="">Select To Percentange</option>
								  <option value="0">0%</option>
                                  <option value="10">10%</option>
                                  <option value="20">20%</option>
                                  <option value="30">30%</option>
                                  <option value="40">40%</option>
                                  <option value="50">50%</option>
                                  <option value="60">60%</option>
                                  <option value="70">70%</option>
                                  <option value="80">80%</option>
                                   <option value="90">90%</option>
                                  <option value="100">100%</option>
                               </select></div>              
								<div class="col-sm-2"> <button class="btn btn-primary form-control" id="btn_submit" type="button" >Search</button> </div>
                            </div>
							
                        </div>
                    </div>
                </div>

            </div>    
        </div>


		  <div class="row ">		   
            <div class="col-sm-12">
				<div class="panel">				 
                    <div class="panel-body" style="overflow:scroll;">
                     <div id="wait" style="display:none;"><div class="loader"></div><br>Loading..</div>
						<div class="col-sm-12">
                        <div class="table-info" id="studtbl" >  
							<!--  <table id="dis_data" class="table table-bordered">
                        <thead>
                            <tr>
                                      <th>SrNo.</th>
                                      <th> Academic Year</th>    
                                      <th> Academic Session</th>   
                                      <th> NAME</th>   
                                      <th> Stream</th>   
                                      <th> SEM</th> 
                                      <th> DIV </th>                                   
                                     <th> Total Lectures</th> 
                                      <th> Total Present</th> 
     <th> Total Absent</th> 
     <th> Percentage</th> <th></th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer1"> -->
<?php // $i=1;

// foreach ($absent_stud_list as $key => $value) {
	                    
// echo "<tr>";
// echo "<td>".$i."</td>";
// echo "<td>".$value['academic_year']."</td>";
// echo "<td>";
// if($value['academic_session']=='WIN'){ echo 'WINTER'; }elseif($value['academic_session']=='SUM'){
// echo 'SUMMER';
// }

// echo "</td>";
// echo "<td>".$value['first_name']." ".$value['last_name']."</td>";
// echo "<td>".$value['stream_short_name']."</td>";
// echo "<td>".$value['semester']."</td>";
// echo "<td>".$value['division']."</td>";
// echo "<td>".($value['tpresent']+$value['tapsent'])."</td>";
// echo "<td>".$value['tpresent']."</td>";
// echo "<td>".$value['tapsent']."</td>";

// echo "<td>".$value['percen_lecturs']."</td>";
// $s=$value['academic_year']."~".$value['academic_session']."~".$value['enrollment_no']."~".$value['semester']."~".$value['division'];
// echo "<td><a href='".base_url()."Student_attendance/get_student_list_apsent_details/".$s."' target='_blank'>View</a></td>";

// echo "</tr>";
// $i++;
// }

?>
                       <!--  </tbody>
                       </table> -->
							
						</div>
                    </div>
                </div>
			</div>
			
		</div>
			
    </div>
</div>
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
$(document).ready(function () {
	//$(document).ajaxStart(function(){
		//alert('ff');
   // $("#wait").css("display", "block");
 // });
  //$(document).ajaxComplete(function(){
   // $("#wait").css("display", "none");
  //});
		$('#dt-datepicker1').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
		$('#dt-datepicker2').datepicker( {format: 'yyyy-mm-dd',endDate: '+0d',autoclose: true});
	var academic_year = '<?=$academicyear?>';
	if (academic_year) {
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Attendance/load_lecture_cources',
			data: {academic_year:academic_year},
			success: function (html) {
				//alert(html);
				var course_id = '<?=$courseId?>';
				$('#course_id').html(html);

				$("#course_id option[value='" + course_id + "']").attr("selected", "selected");
			}
		});
	} else {
		$('#course_id').html('<option value="">Select academic year first</option>');
	}
	var course_id = '<?=$courseId?>';
	//alert(course_id);
	if (course_id) {
		$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Attendance/load_streams',
			data: {course_id:course_id,academic_year:academic_year},
			success: function (html) {
				//alert(html);
				var stream_id = '<?=$streamID?>';
				//alert(stream_id);
				$('#stream_id').html(html);
				$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
			}
		});
	} else {
		$('#stream_id').html('<option value="">Select course first</option>');
	}
		//edit division
		var stream_id2 = '<?=$streamID?>';
			if (stream_id2) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Attendance/getSemfromAttendance',
					data: {stream_id:stream_id2,academic_year:academic_year},
					success: function (html) {
						//alert(html);
						var sem = '<?=$semesterNo?>';
						$('#semester').html(html);
						$("#semester option[value='" + sem + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		//edit semester
		var strem_id1 = '<?=$streamID?>';
		var semesterId1 = '<?=$semesterNo?>';
		//alert(strem_id1);alert(semesterId1);
		if (strem_id1 !='' && semesterId1 !='') {
			//alert('hi');
			$.ajax({
				'url' : base_url + '/Attendance/load_division_by_acdmicyear',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'room_no' : strem_id1,'semesterId':semesterId1,academic_year:academic_year},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#division'); //jquery selector (get element by id)
					if(data){
						//alert(data);
						var division1 = '<?=$division?>';
						//alert(division1);
						container.html(data);
						$("#division option[value='" + division1 + "']").attr("selected", "selected");
					}
				}
			});
		}

		$('#btn_submit').click(function(){
$("#wait").css("display", "block");
//alert('jj');
var ay = $('#academic_year').val();
var schid= $('#sch_list').val();
var cur = $('#course_id').val();
var strm = $('#stream_id').val();
var sem = $('#semester').val();
var divs = $('#division').val();
var fdt = $('#dt-datepicker1').val();
var tdt = $('#dt-datepicker2').val();
var frmper = $('#per_from').val();
var toper = $('#per_to').val();
if(ay=='' || schid==''){
alert('Select Academic Year and School.');
$("#wait").css("display", "none");
}else if(frmper !='' && toper ==''){
	//alert('frmper');//alert(toper);
alert(' Select To percentage ');
$("#wait").css("display", "none");
}else if(frmper =='' && toper !=''){
	//alert(';;');//alert(toper);
alert(' Select From percentage ');
$("#wait").css("display", "none");
}else if((frmper !='' && toper !='') && parseInt(frmper) > parseInt(toper) ){
	//alert(frmper);alert(toper);
alert(' Select proper percentage frequency.');
$("#wait").css("display", "none");
}else{
	//alert('fgfgdf');
$.ajax({
				'url' : base_url + 'Student_attendance/get_student_attendance',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'acd_yer' : ay,'schid':schid,'curs':cur,'strm':strm,'sem':sem,'divis':divs,'fdt':fdt,'tdt':tdt,'frmper':frmper,'toper':toper},
				'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					//jquery selector (get element by id)
					if(data){
						//alert(data);
						$('#studtbl').html(data);
						$("#wait").css("display", "none");
					}
				}
			});
}

		});
    });
$('#dis_data').DataTable( {
        dom: 'Bfrtip',
         targets: 'no-sort',
bSort: false,
     "bPaginate": false,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Student Attendance Report',
                exportOptions: {					
                columns: [0,1,2,3,4,5,6,7,8,9,10]
            }
            },
            {
                extend: 'pdfHtml5',
                title: 'Student Attendance Report',
                exportOptions: {					
                columns: [0,1,2,3,4,5,6,7,8,9,10]
            }
            }
        ]
    } );
	</script>
	

	