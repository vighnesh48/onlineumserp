<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>

<style>
.absent_bg{background:#ff9b9b;}

/*	.table{width: 120%;}
	table{max-width: 120%;}
	*/
	.panel{
    box-shadow: 1px 2px 13px #ccc!important;
}
.panel:hover{
    box-shadow:1px 2px 7px #f2f2f2!important;

}

</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">View Attendance </a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon text-danger"></i>&nbsp;&nbsp;View Attendance</h1>
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
                            <span class="panel-title" id="stdname"> 
							<?php 
							echo "<b>Stream : ".$stream_name.", Semester : ".$semester.", Division : ".$division.''.$batch." </b>"; 
							?>
							</span>						<div class="row pull-right">						<div class="col-sm-12"><div class="col-sm-12" style="margin-right:25px;"><b>T</b>-Total &nbsp;&nbsp;					<b>P</b> -Present &nbsp;&nbsp;					<!--b>NL</b> - No Lecture--><br>					</div></div>					</div>
                    </div>
					
                    <div class="panel-body">
							<?php
						if($course_id==3 || $course_id==9)
						{
							
						}
						else{
						?>
                     
						 <div class="table-info" style="overflow:scroll;height:900px;">  
							<table width="100%" cellpadding="0" cellspacing="0" border="1px" class="table time-table table-striped table-bordered" align="center" >
							
							<tbody>
							   <tr class="info">
									<th align="center" style="width:90px;"><span>Subject / Date</span></th>
									<th align="center"><span>Day</span></th>
									<?php
									$emp_id = $this->session->userdata("name");
									$m=0;
									for($i=0;$i<count($sb);$i++)
									{
									?>
										
									<th align="center"><?=$sb[$i]['subject_short_name']?> <small>(<?=$sb[$i]['subject_code']?>)</small></th>
									<?php
									}?>
									
							   </tr>
								</thead>
								<tbody id="studtbl">
								<?php
								$i=1;
									if(!empty($attCnt)){
										$total_arr = array();
										$total_present = array();
										$total_absent = array();
										foreach($attCnt as $att){
											//echo $att['attendance_date'];
											$attendance_date = date('jS M y', strtotime($att['attendance_date']) );
											$attendance_day = date('D', strtotime($att['attendance_date']) );
								?>
									<tr>
										
										
										<td><?=$attendance_date?></td>
										<td><?=$attendance_day?></td>
										<?php 
										 foreach($att['P_attCnt'] as $key=>$patt){
										?>
										<td>
										<?php 
											if($patt['total'][0]['totlect'] !=0){
												
												$total_arr[$att['subject'][$key]][]=$patt['total'][0]['totlect'];
												for($p=0;$p<$patt[0]['present'];$p++)
												{
													echo "P ";
													//echo $att['subject'][$key];
													$total_present[$att['subject'][$key]][]=1;
													
												}
												for($a=0;$a<$patt['absent'][0]['absentlect'];$a++)
												{
													echo "A ";
													$total_absent[$att['subject'][$key]][]=1;
												}
										?>
										<!--b>T=<?=$patt['total'][0]['totlect']?>, P=<?=$patt[0]['present']?></b-->
										<?php }else{ ?>
											<span style="color:gray">-</span>
										<?php }?>	
										</td>
										 <?php }?>				
									</tr>
									
								<?php 
								//}
										$i++;
										}
									}else{
										echo "<tr><td colspan=6>No data found.</td></tr>";
									}
								?>
								
								<tr style="background-color:#6AFB92">
								<td>Present</td>
								<td></td>
								 <?php 
								 foreach($att['P_attCnt'] as $key=>$patt){
									 ?>
								<td><b>
								<?php 
								$present = array_sum($total_present[$att['subject'][$key]]);
								if($present !=''){
									echo $present;
								}else{
									echo "-";
								}
								?>
								</b></td>
								 <?php }?>
								</tr>
								<tr style="background-color:#efa6a6!important">
								<td style="background-color:#efa6a6!important">Absent</td>
								<td style="background-color:#efa6a6!important"></td>
								 <?php 
								 foreach($att['P_attCnt'] as $key=>$patt){
									 ?>
								<td style="background-color:#efa6a6!important"><b><?php 
								$absent = array_sum($total_absent[$att['subject'][$key]]);
								if($absent !=''){
									echo $absent;
								}else{
									echo "-";
								}
								?></b></td>
								 <?php }?>
								</tr>
								<tr style="background-color:#FFDAB9">
								<td>Total Lect</td>
								<td></td>
								 <?php 
								 foreach($att['P_attCnt'] as $key=>$patt){
									 ?>
								<td><b>
								<?php
								$totlect = array_sum($total_arr[$att['subject'][$key]]);
								if($totlect !=''){
									echo $totlect;
								}else{
									echo "-";
								}
								?>
								</b></td>
								 <?php }?>
								</tr>
								</tbody>
							</table>
							
						</div>
						<?php
						}
						?>
						
						
                    </div>
                </div>
			</div>			
		</div>
			
    </div>
</div>
<script>
$(document).ready(function() {
	$(".viewatt").each(function () {

		$(document).on("click", '#' + this.id, function () {
			var att_date = $('#' + this.id).attr("data-attdate");
			var sub_id = $('#' + this.id).attr("data-attsubid");
			var slot = $('#' + this.id).attr("data-attslot");
			var displaydate = $('#' + this.id).attr("data-displaydate");
			var displayslot = $('#' + this.id).attr("data-displayslot");
			$('#displaydate').html("<b>Date</b> "+displaydate+',');
			$('#displayslot').html("<b>Slot</b> "+displayslot);
		    //alert(att_date);alert(sub_id);alert(slot);
			$.ajax({
					type: 'POST',
					url: '<?= base_url() ?>Attendance/fetchDateSlotwiseAttDetails',
					data: {att_date:att_date,sub_id:sub_id,slot:slot},
					success: function (data) {
						//alert(data);
						if(data!='dupyes'){
							var absent=JSON.parse(data);
							var list_of_absent = absent.ss.length;

							var str="";
							for(i=0;i< list_of_absent;i++)
							{
								var is_present = absent.ss[i].is_present;
								if(is_present=='N'){
									var cls = "style='background-color: rgb(255, 123, 119);'";
								}else{
									cls='';
								}
								//alert("inside");
								//alert(absent.ss[i].enrollment_no);
								str+='<tr '+cls+'>';
								
								str+='<td>'+(i+1)+'</td>';   
								str+='<td>'+absent.ss[i].enrollment_no+'</td>';
								str+='<td>'+absent.ss[i].first_name+' '+absent.ss[i].middle_name+' '+absent.ss[i].last_name+'</td>';
								str+='<td>'+absent.ss[i].mobile+'</td>';
								str+='<td>'+absent.ss[i].is_present+'</td>';
								$("#studAtt").html(str);
							}
							//alert("Refresh.");
						}else{
							alert("No data found");
						}
						
					}
				});
		});
	});
});
</script>
