<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div id="content-wrapper">
<ul class="breadcrumb breadcrumb-page">
	<div class="breadcrumb-label text-light-gray">You are here: </div>
	<li><a href="#">Examination</a></li>
	<li class="active"><a href="#">Malpractice</a></li>
</ul>
<div class="page-header">			
	<div class="row">
		<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Malpractice List</h1>
		
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
							<form name="search_form" id="search_form" method="post" asction="<?=base_url()?>examination/download_exam_applied_stud_data">
							<div class="form-group">
							<label class="col-sm-2">Exam Session</label>
								<div class="col-sm-2">
								<select name="exam_session" id="exam_session" class="form-control" required>
								<option value="">Select Exam Session</option>
                               
								<?php
								foreach($exam_session as $exsession){
									$exam_sess_val = $exsession['exam_month'] .'-'.$exsession['exam_year'] .'-'.$exsession['exam_id'];									$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
									if($exam_sess_val == $_REQUEST['exam_session']){
										$sel = "selected";
									} else{
										$sel = '';
									}
									echo '<option value="' . $exam_sess_val. '"' . $sel . '>' .$exam_sess.'</option>';
								}
								?>									
								</select>	
								</div>
								
							<label class="col-sm-2">Type</label>
								<div class="col-sm-2">
								<select name="report_type" id="report_type" class="form-control" required>
								<option value="">Select Report Type</option>
								<option value="without_timetable" <?php if($_REQUEST['report_type']=='without_timetable'){ echo 'selected';}?>>without timetable</option>
								<option value="with_timetable" <?php if($_REQUEST['report_type']=='with_timetable'){ echo 'selected';}?>>with timetable</option>
								</select>	
								</div>
								<div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="submit" >Search</button> </div>
							</div>
							</form>
						</div>
					</div>
					<div class="panel-body"> 
<?php if(!empty($malpractice_list)){?>
<button class="btn btn-primary pull-right" style="margin-right: 30px" id="export";>Export</button>
<?php }?>					
					
						<div class="table-info table-responsive" id="stddata">    
                 			<table class="table table-bordered" id="table">
	<thead>
		<tr>
                                   
			<th>S.No.</th>
			<th>enrollment_no</th>
			<th>student_name</th>
            <th>mobile&nbsp;Count</th>
			<th>email</th>
			<th>dob</th>
			<th>subject_code </th>
			<th>subject_name</th>
			<th>subject_component</th>		
			<th>exam_date</th>	
<th>session</th>
<th>admission_session</th>
<th>current_semester</th>
<th>school_short_name</th>
<th>course_short_name</th>
<th>stream_name</th>
		</tr>
	</thead>
	<tbody id="itemContainer">
		<?php
		$j=1;
		if(!empty($malpractice_list)){
			for($i=0;$i<count($malpractice_list);$i++){
                                
				?>
				<?php if($malpractice_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
				else $bg="";?>								
				<tr <?=$bg?> <?=$malpractice_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
                                
					<td><?=$j?></td>
                        
					<td><?=$malpractice_list[$i]['enrollment_no']?></td> 
 
					<td>	
						<?php
						echo $malpractice_list[$i]['student_name'];
						?>
					</td> 
                    <td><?=$malpractice_list[$i]['email'];?></td>
					<td><?=$malpractice_list[$i]['dob'];?></td> 
					<td><?=$malpractice_list[$i]['subject_code'];?></td>
					<td><?=$malpractice_list[$i]['subject_name'];?></td>
					<td><?=$malpractice_list[$i]['subject_component'];?></td>  
					  	
					<td><?php echo $malpractice_list[$i]['exam_date'];?></td>
					<td><?=$malpractice_list[$i]['session'];?></td> 
					<td><?=$malpractice_list[$i]['admission_session'];?></td> 
					<td><?=$malpractice_list[$i]['semester'];?></td> 
					<td><?=$malpractice_list[$i]['current_year'];?></td> 
					<td><?=$malpractice_list[$i]['school_short_name'];?></td> 	
<td><?=$malpractice_list[$i]['course_short_name'];?></td> 	
<td><?=$malpractice_list[$i]['stream_name'];?></td> 						
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

						</div>
          
					</div>    
				</div>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
    $('#export').on('click', function(e){
        $("#table").table2excel({
            exclude: ".noExport",
            name: "Data",
            filename: "Workbook",
        });
    });
});
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<script src="//cdn.rawgit.com/rainabba/jquery-table2excel/1.1.0/dist/jquery.table2excel.min.js"></script>

