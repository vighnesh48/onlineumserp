<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div id="content-wrapper">
<ul class="breadcrumb breadcrumb-page">
	<div class="breadcrumb-label text-light-gray">You are here: </div>
	<li><a href="#">Admission</a></li>
	<li class="active"><a href="#">Detention List</a></li>
</ul>
<div class="page-header">			
	<div class="row">
		<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Detention List</h1>
		
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
				<div id="dashboard-recent" class="panel panel-warning">        
					<div class="panel-heading">
							<div class="row" >
							<form name="search_form" id="search_form" method="post" asction="<?=base_url()?>Ums_admission/detaintion_list">
							<div class="form-group">
								<div class="col-sm-2">
								<select name="academicyear" id="academicyear" class="form-control" required>
								<option value="">Select Academic Year</option>
                               
								<?php
								$role_id =$_SESSION['role_id'];
								if($role_id==15){
								foreach($academic_year as $ay){								
									if($ay['academic_year'] == $_REQUEST['academicyear']){
										$sel = "selected";
									} else{
										$sel = '';
									}
									echo '<option value="' . $ay['academic_year']. '"' . $sel . '>' .$ay['academic_year'].'</option>';
								}
								}else{
									foreach($academic_year as $ay){	
										if(($role_id==10 || $role_id==12 || $role_id==20|| $role_id==26) && $ay['currently_active']=='Y'){
									if($ay['academic_year'] == $_REQUEST['academicyear']){
										$sel = "selected";
									} else{
										$sel = '';
									}
									echo '<option value="' . $ay['academic_year']. '"' . $sel . '>' .$ay['academic_year'].'</option>';
								}
									}
								}
								?>
									
								</select>	
								</div>
								
								<div class="col-sm-2">
								<select name="exam_session" id="exam_session" class="form-control" required>
								<option value="">Select Exam Session</option>
                               
								<?php
								if($role_id==15){
								foreach($ex_ses as $ex){
									//$exam_ses_val= $ex['exam_month'].'~'.$ex['exam_year'].'~'.$ex['exam_id'];$exam_ses= $ex['exam_month'].'-'.$ex['exam_year'];	
									$exam_ses_val = $ex['exam_session'];
									$exam_ses1 = explode('~', $ex['exam_session']);
									$exam_ses = $exam_ses1[0].'-'.$exam_ses1[1];
									if($exam_ses_val == $_REQUEST['exam_session']){
										$sel = "selected";
									} else{
										$sel = '';
									}
									echo '<option value="' .$exam_ses_val. '"' . $sel . '>' .$exam_ses.'</option>';
								}
								}else{
									$exam_ses_val1= $ex_ses[0]['exam_month'].'~'.$ex_ses[0]['exam_year'].'~'.$ex_ses[0]['exam_id'];
									$exam_ses1 = $ex_ses[0]['exam_month'].'-'.$ex_ses[0]['exam_year'];
									echo '<option value="' .$exam_ses_val1. '"' . $sel . '>' .$exam_ses1.'</option>';
								}
								?>
									
								</select>	
								</div>
								<?php 
								$role_id = $this->session->userdata('role_id');
								$arr_role= array(10,12,20);
								if($role_id==15){
								?>
								<div class="col-sm-2">
                                <select name="school_code" id="school_code" class="form-control" required>
                                 <option value="">Select School</option>
                                 <option value="0">All School</option>
                                  <?php
									foreach ($schools as $sch) {
									    if ($sch['school_code'] == $_REQUEST['school_code']) {
									        $sel = "selected";
									    } else {
									        $sel = '';
									    }
									    echo '<option value="' . $sch['school_code'] . '"' . $sel . '>' . $sch['school_short_name'] . '</option>';
									}
									?></select>
                              </div>
							  
								<?php }
								if($role_id==10){
									$req ='required';
								}else{
									$req ='';
								}
									
									?>
								<div class="col-sm-2" >
                                <select name="course_id" id="course_id" class="form-control" <?=$req?>>
                                  <option value="">Select Course</option>
                                  <?php
									foreach ($course_details as $course) {
										if ($course['course_id'] == $_REQUEST['course_id']) {
											$sel1 = "selected";
										} else {
											$sel1 = '';
										}
										echo '<option value="' . $course['course_id'] . '"' . $sel1 . '>' . $course['course_short_name'] . '</option>';
									}
									?>
                               </select>
                              </div>
                          
                              <div class="col-sm-2">
                                <select name="stream_id" id="stream_id" class="form-control" <?=$req?>>
                                  <option value="">Select Stream</option>      
                               </select>
                              </div>
								<div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="submit" >Search</button> </div>
							</div>

							</div>
							</form>
						</div>
					</div>
					<div class="panel-body">                
						<div class="table-info table-responsive" id="stddata">    
                 			<table class="table table-bordered" id="table2excel">
	<thead> 
		<tr>
                                   
			<th>S.No.</th>
			<th>PRN</th>
			<th>Name</th>
			<th>Detain Date</th>
			<th>School</th>
			<th>Stream </th>
			<th>Sem</th>
			<th>Exam Session</th>
			<th>Reason</th>		
		</tr>
	</thead>
	<tbody id="itemContainer">
		<?php
		$j=1;
		if(!empty($detaintion_list)){
			for($i=0;$i<count($detaintion_list);$i++){
                       $esession= explode('~', $detaintion_list[$i]['exam_session']);
$exam_session = $esession[0].'-'.$esession[1];					   
				?>
				<?php if($detaintion_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
				else $bg="";?>								
				<tr <?=$bg?> <?=$detaintion_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
                                
					<td><?=$j?></td>
                        
					<td><?=$detaintion_list[$i]['enrollment_no']?></td> 
 
					<td>	
						<?php
						echo $detaintion_list[$i]['first_name']." ".$detaintion_list[$i]['last_name'];
						?>
					</td> 
					<td><?=date('d-m-Y', strtotime($detaintion_list[$i]['created_on']));?></td> 
					<td><?=$detaintion_list[$i]['school_name'];?></td>
					<td><?=$detaintion_list[$i]['stream_short_name'];?></td>
					<td><?=$detaintion_list[$i]['semester'];?></td>  
					 <td><?=$exam_session;?></td>   	
					<td><?php if($detaintion_list[$i]['reason']!=''){ echo $detaintion_list[$i]['reason'];}?></td>
								
								
							
				</tr>

				<?php
				$j++;
			}
		}else{ ?>
								
			<tr><td colspan='9' align='center'>No data found.</td></tr>
			<?php }
		?>                            
	</tbody>
</table>  
<?php if(!empty($detaintion_list)){?>
<button class="btn btn-primary pull-right" style="margin-right: 30px" id="detpdf">Export PDF</button>
<?php }?>
						</div>
          
					</div>    
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">

	$(document).ready(function(){

		$("#detpdf").click(function(){
			var academicyear = $("#academicyear").val();
			var exam_session = $("#exam_session").val();
			var school = $("#school_code").val();
			var stream_id = $("#stream_id").val();
			var exam_session = exam_session.replace("/", "_")
			//alert(stream_id);
			var url = '<?=base_url()?>'+'Ums_admission/detaintion_list_pdf/'+academicyear+'/'+exam_session+'/'+school+'/'+stream_id;
			window.location.href = url;

		});
		
		var base_url = '<?=base_url();?>';
        function load_streams(type){
                   // alert(type);
                var academic_year = $("#academic-year").val();    
                $.ajax({
                    'url' : base_url + '/Ums_admission/load_streams_student_list',
                    'type' : 'POST', //the way you want to send data to your URL
                    'data' : {'course' : type,'academic_year':academic_year},
                    'success' : function(data){ //probably this request will return anything, it'll be put in var "data"
                        var container = $('#admission-branch'); //jquery selector (get element by id)
                        if(data){
                            //alert(data);
                            //alert("Marks should be less than maximum marks");
                            //$("#"+type).val('');
                            container.html(data);
                        }
                    }
                });
            }
		$('#course_id').on('change', function () {			
			var course_id = $(this).val();
			var academic_year = $("#academicyear").val();
			var res = academic_year.split("-");
			if (course_id) {
				$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Ums_admission/load_streams_student_list',
					data: {course:course_id,academic_year:res[0]},
					success: function (html) {
						//alert(html);
						$('#stream_id').html(html);
					}
				});
			} else {
				$('#stream_id').html('<option value="">Select course first</option>');
			}
		});
		var course_id = $("#course_id").val();
		//alert(course_id);
		if (course_id) {
			var academic_year = $("#academicyear").val();
			var res = academic_year.split("-");
			$.ajax({
				'url' : base_url + 'Ums_admission/load_streams_student_list',
				'type' : 'POST', //the way you want to send data to your URL
				data: {course:course_id,academic_year:res[0]},
				'success' : function(data){ 
				//alert(data);
				//probably this request will return anything, it'll be put in var "data"
					var container = $('#stream_id'); //jquery selector (get element by id)
					if(data){
						var stream_id = '<?=$streamId;?>';
						//alert(stream_id);
						container.html(data);
						$("#stream_id option[value='" + stream_id + "']").attr("selected", "selected");
					}
				}
			});
		}
	});
</script>