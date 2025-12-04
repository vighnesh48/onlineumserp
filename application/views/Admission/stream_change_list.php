<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>
<link href="<?=site_url()?>assets/css/bootstrapValidator.css" rel="stylesheet" type="text/css" />
<link href="<?=site_url()?>assets/css/bootstrapValidator.min.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

<div id="content-wrapper">
<ul class="breadcrumb breadcrumb-page">
	<div class="breadcrumb-label text-light-gray">You are here: </div>
	<li><a href="#">Admission</a></li>
	<li class="active"><a href="#">Stream Change List</a></li>
</ul>
<div class="page-header">			
	<div class="row">
		<h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;Stream Change List</h1>
		
		<div class="col-xs-12 col-sm-8">
			<div class="row">                    
				<hr class="visible-xs no-grid-gutter-h">
			</div>
		</div>
	</div>
	<div class="row ">
		<div class="col-sm-12">&nbsp;</div>
	</div>
	<?php
//	var_dump($_SESSION['uid']);
	if($_SESSION['uid']==47 || $_SESSION['uid']==3481 || $_SESSION['uid']==4418)
	{
	?>
	<div class="row ">
		<div class="col-sm-12">
			<div class="panel">
				<div id="dashboard-recent" class="panel panel-warning">        
					<div class="panel-heading">
							<div class="row" >
							<form name="search_form" id="search_form" method="post" asction="<?=base_url()?>Ums_admission/stream_change_list">
							<div class="form-group">
							<label class="col-sm-2">Academic Year</label>
								<div class="col-sm-2">
								<select name="academicyear" id="academicyear" class="form-control" required>
								<option value="">Select Academic Year</option>
                               
								<?php
								foreach($academic_year as $ay){								
									if($ay['academic_year'] == $_REQUEST['academicyear']){
										$sel = "selected";
									} else{
										$sel = '';
									}
									echo '<option value="' . $ay['academic_year']. '"' . $sel . '>' .$ay['academic_year'].'</option>';
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
						<div class="table-info" id="stddata">    
                 			<table class="table table-bordered" id="table2excel">
	<thead>
		<tr>
                                   
			<th>S.No.</th>
			<th>PRN</th>
			<th>Name</th>
			<th>Date</th>
			<th>Previous Stream </th>
			<th>Change to Stream </th>
			<th>Sem</th>
			<th>Status</th>		
		</tr>
	</thead>
	<tbody id="itemContainer">
		<?php
		$j=1;
		if(!empty($stchange_list)){
			for($i=0;$i<count($stchange_list);$i++){
                                
				?>
				<?php if($stchange_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
				else $bg="";?>								
				<tr <?=$bg?> <?=$stchange_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
                                
					<td><?=$j?></td>
                        
					<td><?=$stchange_list[$i]['enrollment_no']?></td> 
 
					<td>	
						<?php
						echo $stchange_list[$i]['first_name']." ".$stchange_list[$i]['last_name'];
						?>
					</td> 
					<td><?=date('d-m-Y', strtotime($stchange_list[$i]['created_on']));?></td> 
					<td><?=$stchange_list[$i]['previous_stream_name'];?></td>
					<td><?=$stchange_list[$i]['change_to_stream_name'];?></td>
					<td><?=$stchange_list[$i]['current_semester'];?></td>  
					  	
					<td id="stm_<?=$stchange_list[$i]['tmp_id']?>">
					<?php if($stchange_list[$i]['is_approved']!=''){
						//echo $stchange_list[$i]['is_approved'];
						if($stchange_list[$i]['is_approved']=='N'){
							$btncls="btn-danger";
						?>
					<button id="<?=$stchange_list[$i]['tmp_id']?>" class="btn <?=$btncls?>" onclick="return changeStream(this.id);"><?=$stchange_list[$i]['is_approved']?></button>
						<?php }else{ ?>
							<button class="btn btn-success">Approved</button>
					<?php	}
					}?>
					</td>
								
								
							
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
<?php if(!empty($stchange_list)){?>
<!--button class="btn btn-primary pull-right" style="margin-right: 30px" id="detpdf">Export PDF</button-->
<?php }?>
						</div>
          
					</div>    
				</div>
			</div>
		</div>
	</div>
	<?php
	}
	?>
</div>
<script type="text/javascript">
function changeStream(tempid){
	//alert(id);

	if(confirm("Are you sure to change the stream of this Student?")){
		//alert(detain);
	$.ajax({
		type: 'POST',
		url: '<?= base_url() ?>Ums_admission/update_stream',
		data: {temp_id:tempid},
		success: function (data) {
			//alert(data);
			if(data=='Y'){
			alert("Updated Successfully..");
			$("#stm_"+tempid).html('<button class="btn btn-success">Approved</button>');
			}else{
				alert("Problem while updation. Kindly check academic fees structure for the stream for perticular  Year.");
			}
		}
	});
	}else {

            return false;
        }
	return true;
} 
	$(document).ready(function(){

		$("#detpdf").click(function(){
			var academicyear = $("#academicyear").val();
			var url = '<?=base_url()?>'+'Ums_admission/stchange_list_pdf/'+academicyear;
			window.location.href = url;

		});
	});
</script>