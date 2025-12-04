<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/jPages.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="<?=base_url('assets/javascripts')?>/jPages.js"></script>
<link rel="stylesheet" href="<?=base_url('assets')?>/stylesheets/select2.css">
<script src="<?=base_url('assets/javascripts')?>/select2.min.js"></script>

<?php
$role_id = $this->session->userdata('role_id');
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Faculty Feedback </a></li>
        
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Faculty Feedback Report</h1>
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
				<div class="row">
				Stream: <?=$sub[0]['stream_name']?>, Semester: <?=$semester?>, Division: <?=$division?>, Cycle:<?=$cycle?> 
				<a href="<?=base_url()?>feedback/faculty_feedback_report"><button class="btn btn-primary pull-right">back</button>
					<!--form name="searchTT" method="POST" action="<?=base_url()?>feedback/faculty_feedback_report_view">
						<div class="form-group">
							
                              <div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" onchange="load_streams(this.value)" required readonly>
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
                              
                              <div class="col-sm-2" id="semest" >
                                <select name="stream_id" class="form-control" id="stream_id" required readonly>
                                  <option value="">Select Stream </option>
                                  
                               </select>
                              </div>	
								<?php
							  if($role_id ==3){
								  ?>
								<div class="col-sm-2">
									<select id="semester" name="semester" class="form-control" required readonly>
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
									<select id="division" name="division" class="form-control" required readonly>
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
									<select id="semester" name="semester" class="form-control" readonly>
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
									<select id="division" name="division" class="form-control" readonly>
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
                              </form!--> 
					</div>
				</div>
				<br>
				
						
                        <div class="table-info">  
						    <div class="pull-right" style="margin-right: 15px;margin-bottom: 10px;">
								<?php
									//if(!empty($_REQUEST['division'])){
									    $stud_details1 = $streamId.'~'.$semester.'~'.$division.'~'.$fbdses;
									?>
									<a href="<?=base_url()?>Feedback/faculty_feedback_report_view_pdf/<?=base64_encode($stud_details1)?>/<?=$cycle?>"style="color:red" title="Summary"><button ><i class="fa fa-file-pdf-o" aria-hidden="true"> Summary</i></button></a>&nbsp;&nbsp; &nbsp;
									
									
									<?php

									//}
									?>
								</div>
								<div class="table-info">  
						    
							<table width="100%" cellpadding="0" cellspacing="0" border="1px" class="table time-table table-striped table-bordered" align="center" >
							
							<thead>
							   <tr>
									<th align="center"><span>Sr.No</span></th>
									<th align="center"><span>Subject Name</span></th>
									<th align="center"><span>Faculty Name</span></th>
									<th align="center"><span>Status</span></th>
									<th align="center"><span>#Feedback</span></th>
									<th align="center"><span>Marks</span></th>
									<th align="center"><span>Outof</span></th>
									<th align="center"><span>%Per</span></th>
									<th align="center"><span>Download</span></th>
									
							   </tr>
								</thead>
								<tbody id="studtbl">
								<?php
								//echo "<pre>";
								//print_r($sub);
								//exit;
								$i=1;
									if(!empty($sub)){
										
										foreach($sub as $sb){
										$stud_details = $streamId.'~'.$semester.'~'.$division.'~'.$sb['subject_code'].'~'.$sb['faculty_code'];
											if($sb['gender']=='male'){
												$sex = 'Mr.';
											}else{
												$sex = 'Mrs.';
											}
										$mrks = $sb['mrks'][0]['Tot_marks'];
										$outoff =$sb['fb'][0]['STUD_CNT']*50;	
								?>
									<tr>
										
										<td><?=$i?></td>
										<td><?=$sb['subject_name']?></td>
										<td><?=$sex.' '.$sb['fname'].' '.$sb['mname'].' '.$sb['lname']?></td>
										<td> 
										<?php 
											if($sb['fb'][0]['feedback_id'] !=''){
										?>
										<button class="btn btn-success">Submitted</button>
										<!--a href="<?=base_url()?>Feedback/view/<?=base64_encode($stud_details)?>"><button class="btn btn-success">View</button></a-->
										<?php
											}else{?>
											<button class="btn btn-danger">Feedback Form</button>
										<?php	}
										?>
										</td>
										<td><?php if($sb['fb'][0]['STUD_CNT'] !=''){ echo $sb['fb'][0]['STUD_CNT'];}?></td>
										<td><?=$mrks?></td>
										<td><?=$outoff?></td>
										<td><?=round($mrks/$outoff * 100);?>%</td>
										<td>
										<?php 
											if($sb['fb'][0]['feedback_id'] !=''){
										?>
										<a href="<?=base_url()?>Feedback/download_report/<?=base64_encode($stud_details)?>/<?=$fbdses?>/<?=$cycle?>"style="color:red"><button ><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></a>
										 <!--| <a href="<?=base_url()?>Feedback/download_excel/<?=base64_encode($stud_details)?>"style="color:green"><button ><i class="fa fa-file-excel-o" aria-hidden="true"></i></button></a--> 
										<?php
											}else{?>
												
										<?php	}
										?>
										
										</td>
											
									</tr>
									
								<?php 
								//}
										$i++;
										}
									}else{
										echo "<tr><td colspan=6>No data found.</td></tr>";
									}
								?>
								
								<tr>
								    <td colspan=8></td>
								    <td>
								        <?php
									//if(!empty($_REQUEST['division'])){
									  
									?>
									<a href="<?=base_url()?>Feedback/all_faculty_report_pdf/<?=$semester?>/<?=$streamId?>/<?=$division?>/<?=$fbdses?>/<?=$cycle?>"style="color:red" title="Download All"><button ><i class="fa fa-file-pdf-o" aria-hidden="true"> All</i></button></a>
									
									<?php

									//}
									?>
								    </td>
								    
								</tr>
								</tbody>

							</table>
							
						</div>
                    </div>
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

		var courseid ='<?=$this->uri->segment(6)?>';
			//alert(course_id);
			if (courseid) {
				$.ajax({
						'url' : base_url + '/Batch_allocation/load_streams',
						'type' : 'POST', //the way you want to send data to your URL
						'data' : {'course_id' : courseid},
						'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
							var container = $('#stream_id'); //jquery selector (get element by id)
							if(data){
								var stream_id = '<?=$this->uri->segment(3)?>';
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
$(document).ready(function()
{
	var division='<?=$this->uri->segment(5)?>'; 
	var semester='<?=$this->uri->segment(4)?>';
	var course ='<?=$this->uri->segment(6)?>';
	var stream ='<?=$this->uri->segment(3)?>';
	if(division!="" && semester!="")
	{
		$('#division option').each(function()
		 {              
			 if($(this).val()== division)
			{
			$(this).attr('selected','selected');
			}
		});
		$('#semester option').each(function()
		 {              
			 if($(this).val()== semester)
			{
			$(this).attr('selected','selected');
			}
		});
		$('#course_id option').each(function()
		 {              
			 if($(this).val()== course)
			{
			$(this).attr('selected','selected');
			}
		});
		$("#btn_submit").trigger("click");
	}
	
	   
});        
</script>