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
		<a href="<?=base_url()?>examination/malpractice_add" target="_blank"><button class="btn btn-primary pull-right" style="margin-right: 30px">Add</button></a>
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
							<form name="search_form" id="search_form" method="post" asction="<?=base_url()?>examination/malpractice_list">
							<div class="form-group">
							<label class="col-sm-2">Exam Session</label>
								<div class="col-sm-2">
								<select name="exam_session" id="exam_session" class="form-control" required>
								<option value="">Select Exam Session</option>
                               
								<?php
								foreach($exam_session as $exsession){
									$exam_sess_val = $exsession['exam_month'] .'-'.$exsession['exam_year'] .'-'.$exsession['exam_id'];									
									$exam_sess = $exsession['exam_month'] .'-'.$exsession['exam_year'];
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
								<div class="col-sm-2"><button class="btn btn-primary form-control" id="sbutton" type="submit" >Search</button> </div>
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
            <th>malpractice&nbsp;Count</th>
			<th>Repetition Count</th>
			<th>Exam Date</th>
			<th>Subject</th>
			<th>Stream </th>
			<th>Sem</th>
			<th>Remark</th>		
			<th>Report</th>	

		</tr>
	</thead>
	<tbody id="itemContainer">
		<?php
		$j=1;
		$CI =& get_instance();
		$CI->load->model('Examination_model');
		if(!empty($malpractice_list)){
			for($i=0;$i<count($malpractice_list);$i++){
                                
				?>
				<?php 
				 $mcount = $this->Examination_model->malpractice_count($malpractice_list[$i]['enrollment_no']);
				if($malpractice_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
				else $bg="";?>								
				<tr <?=$bg?> <?=$malpractice_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
                                
					<td><?=$j?></td>
                        
					<td><?=$malpractice_list[$i]['enrollment_no']?></td> 
 
					<td>	
						<?php
						echo $malpractice_list[$i]['first_name']." ".$malpractice_list[$i]['last_name'];
						?>
					</td> 
                    <td><?=$malpractice_list[$i]['malcount'];?></td>
                    <td><?=$mcount['0']['malcount'];?></td>
					<td><?=date('d-m-Y', strtotime($malpractice_list[$i]['date']));?></td> 
					<td><?=$malpractice_list[$i]['subject_code'].'-'.$malpractice_list[$i]['subject_short_name'];?></td>
					<td><?=$malpractice_list[$i]['stream_short_name'];?></td>
					<td><?=$malpractice_list[$i]['semester'];?></td>  
					  	
					<td><?php if($malpractice_list[$i]['remark']!=''){ echo $malpractice_list[$i]['remark'];}?></td>
					<td><a  href="<?php echo base_url()?>examination/malpractice_report/<?=$malpractice_list[$i]['enrollment_no']?>/<?=$malpractice_list[$i]['date']?>" title="View" target="_blank" <?=$disable?>><i class="fa fa-file-pdf-o" aria-hidden="true"  style="font-size:20px;color:red;"></i></a></td>

				

								
							
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
<?php if(!empty($malpractice_list)){?>
<button class="btn btn-primary pull-right" style="margin-right: 30px" id="malpexcl">Export Excel</button>
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

		$("#malpexcl").click(function(){
			var exam_sess1 = $("#exam_session").val();
			var exam_sess = exam_sess1.replace("/", "_");
			
			var url = '<?=base_url()?>'+'examination/malpractice_excelReports/'+exam_sess;
			window.location.href = url;

		});
	});
</script>