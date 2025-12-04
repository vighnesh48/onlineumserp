<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>
<style>

.table-striped > tbody > tr th{background-color:#6dcff6!important;text-align: center!important;text-transform:uppercase;font-size:13px }
.table-striped > tbody > tr:nth-child(odd) > td{background-color:#c4dae3!important}
.table-striped > tbody > tr:nth-child(even) > td{background-color:#d9eef7!important}
.time-table{border:2px solid #4d717f}
.time-table > thead > tr > th, .time-table > tbody > tr > th, .time-table > tfoot > tr > th, .time-table > thead > tr > td, .time-table > tbody > tr > td, .time-table > tfoot > tr > td{
	border-right:2px solid #4d717f;
}
.time-table > tbody > tr td{font-size:12px;}
	.time-table > thead > tr > th, .time-table > tbody > tr > th, .time-table > tfoot > tr > th, .time-table > thead > tr > td, .time-table > tbody > tr > td, .time-table > tfoot > tr > td{
	border-bottom:2px solid #4d717f
}
.table-striped{font-size:12px;}
.sub-name{text-transform: uppercase;font-size:12px;}
.theme-default .bordered, .theme-default .panel, .theme-default .table, .theme-default hr{border-color:#4d717f!important}
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
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Time table</h1>
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
						}
						?>
                        
                </div>
                <div class="panel-body">
					<?php 
					if($role_id !='4' && $role_id !='9'){
					?>
					<div class="row">
					<form name="searchTT" method="POST" action="<?=base_url()?>timetable/viewTtable">
						<div class="form-group">
							
                              <div class="col-sm-3" >
                                <select name="course_id" id="course_id" class="form-control" onchange="load_streams(this.value)" required>
                                  <option value="">Select Course</option>
                                  <?php
									foreach ($course_details as $course) {
										if ($course['course_id'] == $_REQUEST['course_id']) {
											$sel = "selected";
										} else {
											$sel = '';
										}
										echo '<option value="' . $course['course_id'] . '"' . $sel . '>' . $course['course_short_name'] . '</option>';
									}
									?>
                               </select>
                              </div>
                              <script>
                                     var base_url = '<?php
										echo site_url();
										?>';
                                      function load_streams(type){
											   // alert(type);
												
											$.ajax({
												'url' : base_url + '/Subject/load_streams',
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
										
                                    </script>
                              
                              <div class="col-sm-3" id="semest" >
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
											<?php 
											$semesterNo = $_REQUEST['semester'];
											for($i=0;$i<count($emp_sem);$i++) {
												if ($emp_sem[$i]['semester'] == $semesterNo) {
													$sel3 = "selected";
												} else {
													$sel3 = '';
												}
											?>
											<option value="<?=$emp_sem[$i]['semester']?>" <?=$sel3?>><?=$emp_sem[$i]['semester']?></option>
											<?php } ?>
									</select>
								</div> 
								<div class="col-sm-2">
									<select id="division" name="division" class="form-control">
											<option value="">Division</option>
											<?php 
											//$div = array('A','B','C','D','E','F');
											
											for($i=0;$i<count($emp_div);$i++) {
												if ($emp_div[$i]['division'] == $_REQUEST['division']) {
													$sel4 = "selected";
												} else {
													$sel4 = '';
												}
											?>
											<option value="<?=$emp_div[$i]['division']?>" <?=$sel4?>><?=$emp_div[$i]['division']?></option>
											<?php } ?>
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
                              </form> 
					</div>
					<?php }?>
                    <div class="table-info">    
                    <?php //if(in_array("View", $my_privileges)) { ?>
                    
                    			<?php
						if($course_id==3 || $course_id==9)
						{
							
						}
						else{
						?>
                    <table width="100%" cellpadding="0" cellspacing="0" border="1px" class="table time-table table-striped table-bordered" align="center" >
    <tbody>
       <tr>
            <th align="center"><span style="color:#fff">Day / Time</span></th>
			<?php
			$emp_id = $this->session->userdata("name");
			$m=0;
			for($i=0;$i<count($slot_time);$i++)
			{
				
				if($slot_time[$i]['subject_type'] !='PR'){
					//$arr_frmtime[]=$slot_time[$i]['from_time'];
				?>
				
            <th align="center"><?=$slot_time[$i]['from_time']?> <?=$slot_time[$i]['slot_am_pm']?><br>to<br><?=$slot_time[$i]['to_time']?></th>
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
								$bk_color = "style='background-color: #4CAF50!important;'";
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
									$bkth_color = "style='background-color: #4CAF50!important;'";
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
											$bkpr_color = "style='background-color: #4CAF50!important;'";
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
<script>
$(document).ready(function()
{
var course_id = $("#course_id").val();
		//alert(course_id);
		if (course_id) {
			$.ajax({
				'url' : base_url + '/Batch_allocation/load_streams',
				'type' : 'POST', //the way you want to send data to your URL
				'data' : {'course_id' : course_id},
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