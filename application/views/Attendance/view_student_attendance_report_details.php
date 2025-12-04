<script src="<?=base_url('assets/javascripts').'/bootstrap-datepicker.js'?> "></script>

<style>
.absent_bg{background:#ff9b9b;}

/*	.table{width: 120%;}
	table{max-width: 120%;}
	*/

</style>
<?php
    $astrik='<sup class="redasterik" style="color:red">*</sup>';
?>
<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>
        <li><a href="#">Masters</a></li>
        <li class="active"><a href="#">View Attendance</a></li>
    </ul>
    <div class="page-header">			
        <div class="row">
            <h1 class="col-xs-12 col-sm-4 text-center text-left-sm"><i class="fa fa-dashboard page-header-icon"></i>&nbsp;&nbsp;View Attendance</h1>
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
							echo "<b>Name: ".$student_name." &nbsp; Stream : ".$stream_name.", Semester : ".$semester.", Division : ".$division.''.$batch." </b>"; 
							?>
							</span>						<div class="row pull-right">						<div class="col-sm-12"><div class="col-sm-12" style="margin-right:25px;"><b>T</b>-Total &nbsp;&nbsp;					<b>P</b> -Present &nbsp;&nbsp;					<!--b>NL</b> - No Lecture--><br>					</div></div>					</div>
                    </div>
					
                    <div class="panel-body">
							<?php //echo $course_id;
					//	if($course_id==3 || $course_id==9)
					//	{
							
					//	}
					//	else{
						?>
                     
						 <div class="table-info" style="overflow:scroll;height:900px;">  
							<table id="dis_data" width="100%" cellpadding="0" cellspacing="0" border="1px" class="table time-table table-striped table-bordered" align="center" >
							
							<thead>
							   <tr>
									<th align="center" ><span>Subject / Date</span></th>
									<th align="center"><span>Day</span></th>
									<?php
									//$emp_id = $this->session->userdata("name");
									$emp_id = $std_enr_no;
									$m=0;
									for($i=0;$i<count($sb);$i++)
									{
									?>
										
									<th align="center"><?=$sb[$i]['subject_short_name']?> <small>(<?=$sb[$i]['subject_code']?>)</small></th>
									<?php
									}?>
									<td>Total</td>
							   </tr>
								</thead>
								<tbody >
								<?php
								$i=1; 
//echo "<pre>";
							//	print_r($attCnt);
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
													echo "<span style='color:green;'>P </span>";
													//echo $att['subject'][$key];
													$total_present[$att['subject'][$key]][]=1;
													
												}
												for($a=0;$a<$patt['absent'][0]['absentlect'];$a++)
												{
													$st= $this->Student_Attendance_model->get_lec_details($att['attendance_date'],$att['subject'][$key],$att['stud_id']);
													echo "<span style='color:red;'>A <br/><span style='font-size:10px;'>(".$st[$a]['from_time']." - ".$st[$a]['to_time']." ".$st[$a]['slot_am_pm'].")</span><br/><span style='font-size:10px;'>(".$st[0]['fname']."  ".$st[0]['lname'].")</span> </span><br/>";
													$total_absent[$att['subject'][$key]][]=1;
												}
										?>
										<!--b>T=<?=$patt['total'][0]['totlect']?>, P=<?=$patt[0]['present']?></b-->
										<?php }else{ ?>
											<span style="color:gray">-</span>
										<?php }?>	
										</td>
										 <?php }?>	
										 <td>-</td>			
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
								<td><span style='color:green;'>Present</span></td>
								<td></td>
								 <?php $gt_pre=[];
								 foreach($att['P_attCnt'] as $key=>$patt){
									 ?>
								<td><b>
								<?php 
								$present = array_sum($total_present[$att['subject'][$key]]);
								if($present !=''){
                                   $gt_pre[]=$present;
									echo "<span style='color:green;'>".$present."</span>";
								}else{
									echo "-";
								}
								?>
								</b></td>
								 <?php }?>
								 <td><b><span style='color:green;'><?php echo array_sum($gt_pre); ?></span></b></td>
								</tr>
								<tr>
								<td><span style='color:red;'>Absent</span></td>
								<td></td>
								 <?php $gt_abs=[];
								 foreach($att['P_attCnt'] as $key=>$patt){
									 ?>
								<td><b><?php 
								$absent = array_sum($total_absent[$att['subject'][$key]]);
								if($absent !=''){
									echo "<span style='color:red;'>".$absent."</span>";
$gt_abs[]=$absent;
								}else{
									echo "-";
								}
								?></b></td>
								 <?php }?>
								 <td><b><span style='color:red;'><?php echo array_sum($gt_abs); ?></span></b></td>
								</tr>
								<tr>
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
								  <td><b><?php echo (array_sum($gt_pre)+array_sum($gt_abs)); ?></b></td>
								</tr>
								</tbody>
							</table>
							
						</div>
						<?php
					//	}
						?>
						
						
                    </div>
                </div>
			</div>			
		</div>
			
    </div>
</div>
<script src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
<script>
$(document).ready(function() {
	$('#dis_data').DataTable( {
        dom: 'Bfrtip',
         targets: 'no-sort',
bSort: false,
searching: false,
     "bPaginate": false,
        buttons: [           
            {
                extend: 'pdfHtml5',
                title: 'Student Attendance Report',
                orientation: 'landscape'
            }
        ]
    } );
		
});
</script>
