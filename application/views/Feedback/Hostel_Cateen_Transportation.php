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
							<form name="searchTT" method="POST" action="<?=base_url()?>feedback/HCT_feedback_report">
								<div class="form-group">
							
									<div class="col-sm-2" >
										<select name="fbsession" id="fbsession" class="form-control" required>
											<option value="">Select Session</option>
											<?php
											foreach($fbsession as $fbs){
												$fbvalue = $fbs['academic_type'].'~'.$fbs['academic_year'];
												
												//$actses1 = $actses[0];
												if($fbvalue == $fbses){
													$sel = "selected";
												} else{
													$sel = '';
												}
												echo '<option value="' . $fbvalue . '"' . $sel . '>' . $fbs['academic_type'] . '-'.$fbs['academic_year'].' </option>';
											}
											?>
										</select>
									</div>
									<div class="col-sm-2" >
										<select name="fbcycle" id="fbcycle" class="form-control" required>
											<option value="">Select Cycle</option>
											<option value="1" <?php if($fbcycle==1){ echo 'selected';}?>>Cycle 1</option>
											<option value="2" <?php if($fbcycle==2){ echo 'selected';}?>>Cycle 2</option>
										</select>
									</div>
									 <div class="col-sm-2" >
										<select name="fbschool" id="fbschool" class="form-control" required>
											<option value="">Select Type</option>
                                            <option value="All" <?php if($fbschool=="All"){ ?> selected<?php } ?>>All</option>
                                            <option value="Group" <?php if($fbschool=="Group"){ ?> selected<?php } ?>>Group By</option>
                                            <option value="Canteen" <?php if($fbschool=="Canteen"){ ?> selected<?php } ?>>Canteen</option>
                                            <option value="Transportation" <?php if($fbschool=="Transportation"){ ?> selected<?php } ?>>Transportation</option>
                                            <option value="Hostel" <?php if($fbschool=="Hostel"){ ?> selected<?php } ?>>Hostel</option>

											<?php
										/*	foreach($schools as $sch){
												$schvalue = $sch['school_code'];
												
												//$actses1 = $actses[0];
												if($schvalue == $fbschool){
													$sel = "selected";
												} else{
													$sel = '';
												}
												echo '<option value="' . $schvalue . '"' . $sel . '>' . $sch['school_name'].' </option>';
											}
											*/
											?>
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
							$PDF='YES';
						     $_REQUEST['division'];
							 $stud_details1 = $academic_type.'~'.$academic_year.'~'.$school.'~'.$PDF;
								?>
								<a href="<?=base_url()?>Feedback/HCT_feedback_report_Pdf/<?=base64_encode($stud_details1)?>" style="color:red" title="Download All"><button ><i class="fa fa-file-pdf-o" aria-hidden="true"> All</i></button></a>
								<?php

						//	}
							?>
						</div>
						<table width="100%" cellpadding="0" cellspacing="0" border="1px" class="table time-table table-striped table-bordered" align="center" >
							
							<thead>
								<tr>
									<th align="center"><span>Sr.No</span></th>
									<th align="center"><span>Category</span></th>
									<!--<th align="center"><span>Academic Year</span></th>
									<th align="center"><span>Type</span></th>-->
               <?php if(($fbschool=="All")||($fbschool=="Canteen")||($fbschool=="Transportation")||($fbschool=="Hostel")){ ?>
									<th align="center"><span>Student Id</span></th>
                                    <th align="center"><span>Student Name</span></th>
                                    <?php } ?>
                                    
									<th align="center"><span>#Total Mark</span></th>
									<!--th align="center"><span>#studAppeared</span></th-->
									<th align="center"><span>#Total %</span></th>
									<!--<th align="center"><span>Action</span></th>-->
									
									
								</tr>
							</thead>
                            <?php 
							$total_allm=0;
								$total_allp=0;
							if(!empty($All_data)){
									//echo "<pre>";		
									$count_all=count($All_data);								//print_r($class);
									foreach($All_data as $fbcls){
										$total_allm +=$fbcls['Totalm'];
										$total_allp +=(int)$fbcls['Total_perct'];
									}
									$total_allp =(int)($total_allp / $count_all );
							}
							
							?>
                            
                            <tr>
									<td align=""></td>
									<td align=""></td>
									
               <?php  if(($fbschool=="All")||($fbschool=="Canteen")||($fbschool=="Transportation")||($fbschool=="Hostel")){ ?>
									<td align=""></td>
                                    <td align=""></td>
                                    <?php } ?>
                                    
									<td align=""><b>Total  </b> <b><?php echo $total_allm; ?></b></td>
									
									<td align=""><b>Avg <?php echo $total_allp; ?> %</b></td>
								
									
									
								</tr>
                            
							<tbody id="studtbl">
                            
                            
                            
								<?php
								$j=0;
								$i=1;
								
								//echo "<pre>";
								//print_r($class);
								
								if(!empty($All_data)){
									//echo "<pre>";		
									$count_all=count($All_data);								//print_r($class);
									foreach($All_data as $fbcls){
										/*$stud_cnt = count($fbcls['class_studcnt']);
										$fdappeared_studcnt = count($fbcls['fdappeared_studcnt']);										
										$studcnt_submitted = count($fbcls['studcnt_submitted']);
										$sub_cnt[] =$studcnt_submitted; 
										if($fbcls['stream_id']=='9'){
											$stream_name='B.Tech First Year';
										}else{
											$stream_name=$fbcls['stream_short_name'];
										}*/
										?>
										<tr>
										
											<td><?=$i?></td>
											<td><?=$fbcls['question_name']?></td>
											<!--<td><?=$fbcls['academic_year']?></td>
											<td><?=$fbcls['academic_type']?></td>-->
											
 <?php if(($fbschool=="All")||($fbschool=="Canteen")||($fbschool=="Transportation")||($fbschool=="Hostel")){ ?>
 <td><?=$fbcls['student_id']?></td>
 <td><?=$fbcls['first_name']?></td>
 <?php } ?>
											<td><?=$fbcls['Totalm']?></td>
                                            <td><?=(int)$fbcls['Total_perct']?> %</td>	
																		
											<!--<td>
												

											</td>-->
											
										</tr>
									
										<?php 
										//$total_allm +=$fbcls['Totalm'];
										//$total_allp +=(int)$fbcls['Total_perct'];
										
										$i++;									
											//unset($stud_cnt);unset($stud_cnt);
									}
									//$total_allp =(int)($total_allp / $count_all );
									?>
									
									<?php
								}else{
									echo "<tr>
									<td colspan=8>No data found.</td></tr>";
								}
							//	echo "<tr><td colspan=8> Total Feedback Submitted: <b>".array_sum($sub_cnt)."</b></td></tr>";
								//echo array_sum($sub_cnt);
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