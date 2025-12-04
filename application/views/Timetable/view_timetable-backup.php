<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" type="text/css" />
<link href="https://cdn.datatables.net/buttons/1.5.6/css/buttons.dataTables.min.css" type="text/css"/>
<style>

.table-striped > tbody > tr th{background-color:#DDAC20!important;text-align: center!important;text-transform:uppercase;font-size:13px }
.table-striped > tbody > tr:nth-child(odd) > td{background-color:#FFCC0080!important}
.table-striped > tbody > tr:nth-child(even) > td{background-color:#FF66!important}
.time-table{border:2px solid #000}
.time-table > thead > tr > th, .time-table > tbody > tr > th, .time-table > tfoot > tr > th, .time-table > thead > tr > td, .time-table > tbody > tr > td, .time-table > tfoot > tr > td{
	border-right:2px solid #000;border-left:2px solid #000;border-top:2px solid #000;
}
.time-table > tbody > tr td{font-size:12px;}
	.time-table > thead > tr > th, .time-table > tbody > tr > th, .time-table > tfoot > tr > th, .time-table > thead > tr > td, .time-table > tbody > tr > td, .time-table > tfoot > tr > td{
	border-bottom:2px solid #000
}
.table-striped{font-size:12px;}
.sub-name{text-transform: uppercase;font-size:12px;}
.theme-default .bordered, .theme-default, .theme-default .table, .theme-default hr{border-color:#4d717f!important}
.table{width:100%}
</style>
<?php
$role_id = $this->session->userdata('role_id');
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">View Time table</a></li>
        
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-calendar page-header-icon"></i>&nbsp;&nbsp;Lecture Time Table 12</h1>
            <div class="col-xs-12 col-sm-8">
            </div>
        </div>
        <div class="row ">
            <div class="col-sm-12">&nbsp;</div>
        </div>
        <div class="row ">
            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                       <?php 
						if($role_id =='4' || $role_id =='9'){
						 
							echo "<b>Stream : ".$course_short_name.", Semester : ".$semester.", Division :  ".$division.''.$batch." </b>"; 							
						}else{
						
					if($role_id !='4' && $role_id !='9'){
					?>
					<div class="row">
					<form name="searchTT" method="POST" action="<?=base_url()?>timetable/viewTtable">
						<div class="form-group">
							<div class="col-sm-2" >
                                <select name="academic_year" id="academic_year" class="form-control" required>
                                  <option value="">Select Academic Year </option>
                                  <?php
									foreach ($academic_year as $yr) {
										if ($yr['academic_year'].'~'.$yr['academic_session'] == $academicyear) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $yr['academic_year'].'~'.$yr['academic_session'].'"' . $sel . '>' . $yr['academic_year'].'('.$yr['academic_session'] . ')</option>';
									}
									?>
                               </select>
                              </div>
                              <div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" required>
                                  <option value="">Select Course</option>
                                 
                               </select>
                              </div>                        
                              <div class="col-sm-2">
                                <select name="stream_id" class="form-control" id="stream_id" required>
                                  <option value="">Select Stream </option>
                                  
                               </select>
                              </div>	
								<?php
							  if($role_id ==3){
								  ?>
								<div class="col-sm-2">
									<select id="semester" name="semester" class="form-control">
											<option value="">Semester</option>
									</select>
								</div> 
								<div class="col-sm-2">
									<select id="division" name="division" class="form-control">
											<option value="">Division</option>
									</select>
								</div>
							  <?php }else{?>
							  <div class="col-sm-2">
									<select id="semester" name="semester" class="form-control">
											<option value="">Semester</option>
											<?php 
											$semesterNo = $_REQUEST['semester'];
											for($i=1;$i<9;$i++) {
												if ($i == $semesterNo) {
													$sel3 = "selected";
												} else {
													$sel3 = '';
												}
											?>
											<option value="<?=$i?>" <?=$sel3?>><?=$i?></option>
											<?php } ?>
									</select>
								</div> 
								<div class="col-sm-2">
									<select id="division" name="division" class="form-control">
											<option value="">Division</option>
											<?php 
											$div = array('A','B','C','D','E','F');
											
											for($i=0;$i<count($div);$i++) {
												if ($div[$i] == $_REQUEST['division']) {
													$sel4 = "selected";
												} else {
													$sel4 = '';
												}
											?>
											<option value="<?=$div[$i]?>" <?=$sel4?>><?=$div[$i]?></option>
											<?php } ?>
									</select>
								</div>
							  <?php }?>
								<div class="col-sm-2"><input type="submit" class="btn btn-primary" value="Search"></div>
							
								
                            </div>
                            	<div class="col-sm-2"><input type="button" class="btn btn-primary" value="Download Pdf" id="getpdf"></div>
                              </form> 
					</div>
					<?php }
					}?>
                </div>
                <div class="panel-body">
					
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    
                    			<?php
						if($course_id==3 || $course_id==9)
						{
							
						}
						else{
						?>
					<div class="table-responsive">
                    <table width="100%" cellpadding="0" cellspacing="0" border="1px" class="table time-table table-striped table-bordered" align="center" id="search-table" >
    <tbody>
       <tr>
            <th align="center"><span style="color:#fff">Day / Time zfhdjs</span></th>
			<?php
			$emp_id = $this->session->userdata("name");
			$m=0;
			for($i=0;$i<count($slot_time);$i++)
			{
				
				if($slot_time[$i]['subject_type'] !='PR'){
					//$arr_frmtime[]=$slot_time[$i]['from_time'];
				?>
				
            <th align="center" style="color:#FFF"><?=$slot_time[$i]['from_time']?> <?=$slot_time[$i]['slot_am_pm']?><br>to<br><?=$slot_time[$i]['to_time']?></th>
			<?php } 
			}?>
			
       </tr>
	   <?php
			//$j=1; 
			//echo "<pre>";
			//print_r($arr_frmtime);	
			if(!empty($ttsub)){
			for($l=0;$l<count($wday);$l++)
			{
				
			?>
			<tr <?=$slot[$i]["status"]=="N"?"style='background-color:#FBEFF2'":""?>>
				<td align="center"><strong><?=$wday[$l]?></strong></td>
				<?php 
				//echo count($ttsub);
					$pr_count=1;
					$pr_slot="";
					$pr_display="";

					$th_slot="";
					$th_display="";
					
					for($j=0;$j<count($ttsub);$j++){

						$colmn_cnt = 6;
						for($k=0;$k<count($ttsub[$l][$j]);$k++){
							
							$faculty = $ttsub[$l][$j][$k]['faculty_code']; 
							
							//echo $faculty[0];
							if($emp_id==$faculty){
								$bk_color = "style='background-color: #F9BE67!important;'";
							}else{
								$bk_color ='';
							}
							
						?>
						
							<?php 
							if($ttsub[$l][$j][$k]['subject_type']=='TH' && $ttsub[$l][$j][$k]['subject_code'] !=''){
								$faculty_th[] = $ttsub[$l][$j][$k]['faculty_code']; 
								if($th_slot==""){
									$th_display = $ttsub[$l][$j][$k]['sub_code']." (".$ttsub[$l][$j][$k]['subject_short_name'].") <br> ".strtoupper($ttsub[$l][$j][$k]['fname'][0].'. '.$ttsub[$l][$j][$k]['mname'][0].'. '.$ttsub[$l][$j][$k]['lname']);
									$th_slot=$ttsub[$l][$j][$k]['lect_slot_id'];
									
								}
								else if($th_slot=$ttsub[$l][$j][$k]['lect_slot_id']) {
									$th_display .='/<br>'.$ttsub[$l][$j][$k]['sub_code']." (".$ttsub[$l][$j][$k]['subject_short_name'].") <br> ".strtoupper($ttsub[$l][$j][$k]['fname'][0].'. '.$ttsub[$l][$j][$k]['mname'][0].'. '.$ttsub[$l][$j][$k]['lname']);			
								}
								
								$current_slot_th = $ttsub[$l][$j][$k]['lect_slot_id'];
								$next_slot_th = $ttsub[$l][$j][$k+1]['lect_slot_id'];
								
								if(in_array($emp_id, $faculty_th)){
									$bkth_color = "style='background-color: #F9BE67!important;'";
								}else{
									$bkth_color = "";
								}	
								if($current_slot_th != $next_slot_th){


							?>
							<td <?=$bkth_color?>>
							<strong class="sub-name" title="<?=$ttsub[$l][$j][$k]['subject_name']?>" style="cursor:pointer">
							<?php
							
								if($ttsub[$l][$j][$k]['subject_code']== 'OFF'){
									echo "";
								}else if($ttsub[$l][$j][$k]['subject_code']=='Library'){
									echo "Library";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'Tutorial'){
									echo "Tutorial";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'Tutor'){
									echo "Tutor";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'IS'){
									echo "Internet Slot";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'RC'){
									echo "Remedial Class";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'EL'){
									echo "Experiential Learning";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'SPS'){
									echo "Swayam Prabha Session";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'ST'){
									echo "Spoken Tutorial";
								}else if($ttsub[$l][$j][$k]['subject_code']== 'FAM'){
									echo "Faculty Advisor Meet";
								}else{
									echo $th_display;
								}
								?>	
							</strong>
							
							</td>
							
							<?php
							$th_slot="";
							$th_display="";
							$faculty_th="";
								}							
							
							}
							elseif($ttsub[$l][$j][$k]['subject_type']=='PR'){
								
								//echo $timediff = round((strtotime('08:00') - strtotime('11:30')) /3600,0);
								 
								$timediff = round((strtotime($ttsub[$l][$j][$k]['to_time']) - strtotime($ttsub[$l][$j][$k]['from_time'])) /3600,0);
								//echo $ttsub[$l][$j][$k]['from_time'].' -'.$ttsub[$l][$j][$k]['to_time'].'='.$timediff;
								
									$faculty_pr[] = $ttsub[$l][$j][$k]['faculty_code']; 
										if($pr_slot==""){
											$pr_display=$ttsub[$l][$j][$k]['sub_code']." (".$ttsub[$l][$j][$k]['subject_short_name'].")-".$ttsub[$l][$j][$k]['division']."".$ttsub[$l][$j][$k]['batch_no']." / ".strtoupper($ttsub[$l][$j][$k]['fname'][0].'. '.$ttsub[$l][$j][$k]['mname'][0].'. '.$ttsub[$l][$j][$k]['lname']).'<br>';
											$pr_count++;
											$pr_slot=$ttsub[$l][$j][$k]['lect_slot_id'];
											
										}
										else if($pr_slot=$ttsub[$l][$j][$k]['lect_slot_id']) {
											$pr_display.=$ttsub[$l][$j][$k]['sub_code']." (".$ttsub[$l][$j][$k]['subject_short_name'].")-".$ttsub[$l][$j][$k]['division']."".$ttsub[$l][$j][$k]['batch_no']." / ".strtoupper($ttsub[$l][$j][$k]['fname'][0].'. '.$ttsub[$l][$j][$k]['mname'][0].'. '.$ttsub[$l][$j][$k]['lname']).'<br>';
											$pr_count++;
											$pr_slot=$ttsub[$l][$j][$k]['lect_slot_id'];
											
											
										}
										//echo "<pre>";print_r($faculty_pr);//if($pr_slot != $next_slot)
										if(in_array($emp_id, $faculty_pr)){
											$bkpr_color = "style='background-color: #F9BE67!important;'";
										}else{
											$bkpr_color = "";
										}	
								$next_slot=$ttsub[$l][$j][$k+1]['lect_slot_id'];
								if($ttsub[$l][$j][$k]['lect_slot_id'] != $next_slot){ 
									if($timediff > 1){
										$colspan = $timediff;
									}else{
										$colspan = '';
									}
									
								?>
								<td colspan="<?=$colspan?>" <?=$bkpr_color?>>
									<strong class="sub-name" title="" style="cursor:pointer"><?=$pr_display?></strong><br>
							    </td>
											
								<?php	
									unset($timediff);
									unset($colspan);
									unset($pr_display);
								}		
								
							}
							else{
							?>	
							<td colspan="1" <?=$bk_color?>>
									<strong class="sub-name" title="" style="cursor:pointer"></strong><br>
								</td>
							<?php }?>
						
				<?php }
				$faculty_pr="";
				
				//$next_slot="";
				}
				$th_display="";
				$current_slot_th = "";
				$next_slot_th = "";
				?>								
			</tr>
			
			<?php
			//exit;
			
			} 
			}			
			?>
		
</tbody>
</table>  
</div>                 
                    <?php } ?>
                </div>
                </div>
            </div>
            </div>    
        </div>
    </div>
</div>
<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Commerce</h4>
      </div>
      <div class="modal-body">
        <p>Some text in the modal.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>

<form action="<?php echo base_url()?>timetable/downloadpdf" id="exportpf" name="exportpf" method="post">
	<input type="hidden" name="academic_year" id="academic_yearpf" />
	<input type="hidden" name="course_id" id="course_idpf" />
	<input type="hidden" name="stream_id" id="stream_idpf" />
	<input type="hidden" name="semester" id="semesterpf" />
	<input type="hidden" name="division" id="divisionpf" />
	

</form>

 <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script>
$('#search-table').DataTable( {
        dom: 'Bfrtip',
        buttons: [
            {
                extend: 'copyHtml5',
                exportOptions: {
                    columns: [ 0, ':visible' ]
                }
            },
            {
                extend: 'excelHtml5',
                exportOptions: {
                     columns: [ 0, 1, 2,3,4,5,6,7,8]
                }
            },
            {
                extend: 'pdfHtml5',
                exportOptions: {
                    columns: [ 0, 1, 2,3,4,5,6,7,8]
                }
            },
            
        ]
    } );
	</script>
<script>
$(document).ready(function()
{


	$('#academic_year').on('change', function () {
			var academic_year = $(this).val();
			if (academic_year) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttcources',
					data: {academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#course_id').html(html);
					}
				});
			} else {
				$('#course_id').html('<option value="">Select academic year first</option>');
			}
		});
		$('#course_id').on('change', function () {
			var academic_year =$("#academic_year").val();
			var course_id = $(this).val();
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Timetable/load_tt_streams',
					data: {course_id:course_id,academic_year:academic_year},
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
			var academic_year =$("#academic_year").val();
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttsemesters',
					data: {stream_id:stream_id,academic_year:academic_year},
					success: function (html){
						//alert(html);
						$('#semester').html(html);
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}
		});
		//
	var course_id = '<?=$courseId?>';
	var academic_year ='<?=$academicyear?>';
	if (academic_year) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttcources',
					data: {academic_year:academic_year},
					success: function (html) {
						//alert(html);
						$('#course_id').html(html);
						$("#course_id option[value='" + course_id + "']").attr("selected", "selected");
					}
				});
			}
			
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Timetable/load_tt_streams',
					data: {course_id:course_id,academic_year:academic_year},
					'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
					var container = $('#stream_id'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?=$streamId?>';
						container.html(data);
						$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
			var stream_id ='<?=$streamId?>';
			
			if (stream_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttsemesters',
					data: {stream_id:stream_id,academic_year:academic_year},
					success: function (html) {
						var semester = '<?=$semesterNo?>';
						$('#semester').html(html);
						$("#semester option[value='" + semester + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#semester').html('<option value="">Select Stream first</option>');
			}


		$('#semester').on('change', function () {
			var semester = $(this).val();
			var stream_id =$("#stream_id").val();
			var academic_year =$("#academic_year").val();
			if (semester) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttdivision',
					data: {stream_id:stream_id,academic_year:academic_year,stream_id:stream_id, semester:semester},
					success: function (html) {
						
						$('#division').html(html);
						
					}
				});
			} else {
				$('#division').html('<option value="">Select Stream first</option>');
			}
		});

			var semester = '<?=$semesterNo?>';
			if (semester) {
				var academic_year ='<?=$academicyear?>';
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>timetable/load_ttdivision',
					data: {stream_id:stream_id,academic_year:academic_year,stream_id:stream_id, semester:semester},
					success: function (html) {
						var division ='<?=$division?>';
						$('#division').html(html);
						$("#division option[value='" + division + "']").attr("selected", "selected");
					}
				});
			} else {
				$('#division').html('<option value="">Select Stream first</option>');
			}
			
});		
  $("div.holder").jPages
  ({
    containerID : "itemContainer"
  });
  $("#search_me").select2({
      placeholder: "Enter Time table name",
      allowClear: true
    });
        $("#search_me").on('change',function()
        {
            var search_val = $(this).val();            
            var url  = "<?=base_url().strtolower($currentModule).'/search/'?>";	
            var data = {title: search_val};		
            var type="";
            var type_name="";
            $.ajax
            ({
                type: "POST",
                url: url,
                data: data,
                dataType: "html",
                cache: false,
                crossDomain: true,
                success: function(data)
                {                       
                    var array=JSON.parse(data);
                    var str="";
                    for(i=0;i<array.slot.length;i++)
                    {
                        str+='<tr style="display: table-row; opacity: 1;">';
                        str+='<td>'+(i+1)+'</td>';                                                                                                
                        str+='<td>'+array.slot[i].campus_name+'</td>';
                        str+='<td>'+array.slot[i].college_code+'</td>';
                        str+='<td>'+array.slot[i].college_name+'</td>';
                        str+='<td>'+array.slot[i].college_state+'</td>';
                        str+='<td>'+array.slot[i].college_city+'</td>';                        
                        str+='<td>'+array.slot[i].college_pincode+'</td>';
                        str+='<td>'+array.slot[i].college_address+'</td>';
                        str+='<td>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/edit/'+array.slot[i].college_id+'"><i class="fa fa-edit"></i></a>';
                        str+='<a href="<?=base_url(strtolower($currentModule))?>/disable/'+array.slot[i].college_id+'"><i title="Disable" class="fa fa-ban"></i></a>';
                        str+='</td>';
                        str+='</tr>';
                        $("#itemContainer").html(str);
                    }
                },
                error: function(data)
                {
                    alert("Page Or Folder Not Created..!!");
                }
            });
        });
</script>
<script>
	
	$("#getpdf").click(function(){

		$("#academic_yearpf").val($("#academic_year").val());
		$("#course_idpf").val( $("#course_id").val());
		$("#stream_idpf").val($("#stream_id").val());
		$("#semesterpf").val($("#semester").val());
		$("#divisionpf").val($("#division").val());
			
        $("#exportpf").trigger("submit");

	});
</script>