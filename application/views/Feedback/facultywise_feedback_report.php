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
		<li class="active"><a href="#">Feedback </a></li>
        
	</ul>
	<div class="page-header">			
		<div class="row">
			<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Faculty-wise Feedback Report</h1>
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
							<form name="searchTT" method="POST" action="<?=base_url()?>feedback/facultywise_feedback_report">
								<div class="form-group">
							
									<div class="col-sm-2" >
										<select name="school_id" id="school_id" class="form-control" onchange="load_streams(this.value)" required>
											<option value="">Select School</option>
											<?php
											foreach($school_details as $course){
												if($course['college_id'] == $_REQUEST['school_id']){
													$sel = "selected";
												} else{
													$sel = '';
												}
												echo '<option value="' . $course['college_id'] . '"' . $sel . '>' . $course['college_name'] . '</option>';
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
													'url' : base_url + '/Feedback/load_department',
													'type' : 'POST', //the way you want to send data to your URL
													'data' : {'school_id' : type},
													'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
														var container = $('#dept'); //jquery selector (get element by id)
														if(data){
															 // alert(data);
															//alert("Marks should be less than maximum marks");
															//$("#"+type).val('');
															container.html(data);
														}
													}
												});
										}
										$(document).ready(function()
{
										var dept = '<?=$_REQUEST['dept_id']?>';
										var sch = '<?=$_REQUEST['school_id']?>';
										//alert(sch);
										if(sch){
											$.ajax({
													'url' : base_url + '/Feedback/load_department',
													'type' : 'POST', //the way you want to send data to your URL
													'data' : {'school_id' : sch},
													'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
														var container = $('#dept'); //jquery selector (get element by id)
														if(data){
															container.html(data);
															$("#dept option[value='"+dept+"']").attr("selected", "selected");
														}
													}
												});
										}
										
	});
									</script>
                              
									<div class="col-sm-2" id="dept" >
										<select name="dept_id" class="form-control" id="dept_id" required>
											<option value="">Select Department </option>         
										</select>
									</div>	
									
									<div class="col-sm-2"><input type="submit" class="btn btn-primary" value="Search"></div>
								
								</div>
							</form> 
                              
						</div>
					</div>
					<br>
				
						
					<div class="table-info">  
						<div class="pull-right" style="margin-right: 15px;margin-bottom: 10px;">
							<?php
							if(!empty($_REQUEST['division'])){
								?>
								<a href="<?=base_url()?>Feedback/all_faculty_report_pdf/<?=$semester?>/<?=$streamId?>/<?=$division?>"style="color:red" title="Download All"><button ><i class="fa fa-file-pdf-o" aria-hidden="true"> All</i></button></a>
								<?php

							}
							?>
						</div>
						<table width="100%" cellpadding="0" cellspacing="0" border="1px" class="table time-table table-striped table-bordered" align="center" >
							
							<thead>
								<tr>
									<th align="center"><span>Sr.No</span></th>
									<th align="center"><span>Faculty Name</span></th>
									<th align="center"><span>#Feedback</span></th>
									<th align="center"><span>Marks</span></th>
									<th align="center"><span>Outoff</span></th>
									<th align="center"><span>%Per</span></th>
									<th align="center"><span>Download</span></th>
									
								</tr>
							</thead>
							<tbody id="studtbl">
								<?php
								$j=0;
								$i=1;
								$mrks=[];
								$sum_totmarks = 0;									
								//echo "<pre>";
								//print_r($fac);
								if(!empty($fac)){
										
									foreach($fac as $fa){
										//$stud_details = $streamId.'~'.$semester.'~'.$division.'~'.$fa['subject_code'].'~'.$fa['faculty_code'];
										if($fa['gender']=='male'){
											$sex = 'Mr.';
										}else{
											$sex = 'Mrs.';
										}
											
										//$mrks += $fa['mrks'][$j][0]['Tot_marks'];
										foreach($fa['mrks'] as $mrk){
											//echo "<pre>";
											//print_r($mrk);
											$no_of_feedback []= $mrk[0]['STUD_CNT'];
											$mrks[] = $mrk[0]['Tot_marks'];
											//ecarray_sum($mrks);
										}
										$no_of_fb = array_sum($no_of_feedback);
										$mrk_obt = array_sum($mrks);
										$mrk_tot = $no_of_fb *65;
										?>
										<tr>
										
											<td><?=$i?></td>	
											<td><?=$sex.' '.$fa['fac_name']?></td>

											<td> <?php echo $no_of_fb;?></td>
											<td><?=$mrk_obt?></td>
											<td><?=$mrk_tot?></td>
											<td><?=round($mrk_obt/$mrk_tot * 100);?>%</td>
										
											<td>
												<?php 
												if($no_of_fb !=''){
													?>
													<a href="<?=base_url()?>Feedback/facultywise_report_pdf/<?=base64_encode($fa['emp_id'])?>"style="color:red"><button ><i class="fa fa-file-pdf-o" aria-hidden="true"></i></button></a>
													<?php
												}else{?>
												
													<?php	}
												?>
										
											</td>
											
										</tr>
									
										<?php 
										//} 
										unset($mrk_obt);
										unset($mrk_tot);
										unset($no_of_fb);
										$i++;
									}
								}else{
									echo "<tr><td colspan=6>No data found.</td></tr>";
								}
								?>
								
								
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