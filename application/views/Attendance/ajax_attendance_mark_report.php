  <style type="text/css">
  table {  
				font-family: arial, sans-serif;  
				border-collapse: collapse;  
				width: 100%; 
				font-size: 12px; 
				margin: 0 auto;
			}  
			td{
				vertical-align: top;}
             .bapu tr td,.bapu tr th{
				 border:1px solid black;
			 }         
.table-bordered, .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th
{ border-color:#8acc82;}
  </style>
  <?php if($exp !='Y'){ 

    ?>
    <style>
    .row { font-family:"Arial Verdana"; }
    .table{ padding:10px;font-family:"Arial Verdana important"; }
    </style>
<!--div class="row">
<form id="form1" name="form1" action="<?= base_url($currentModule . '/stud_attendance_mark_report_download') ?>" method="post">
<input type="hidden" name="sacd_yer" value="<?=$pdata['acd_yer']?>" />
<input type="hidden" name="ssch_id" value="<?=$pdata['sch_id']?>" />
<input type="hidden" name="scurs" value="<?=$pdata['curs']?>" />
<input type="hidden" name="sstrm" value="<?=$pdata['strm']?>" />
<input type="hidden" name="ssem" value="<?=$pdata['sem']?>" />
<input type="hidden" name="sdivis" value="<?=$pdata['divis']?>" />
<input type="hidden" name="sfdt" value="<?=$pdata['fdt']?>" />
<input type="hidden" name="stdt" value="<?=$pdata['tdt']?>" />
<input type="hidden" name="srtyp" value="<?=$pdata['rtyp']?>" />
<input type="hidden" name="sub_type" value="<?=$pdata['sub_type']?>" />
<div class="col-sm-1"> <button class="btn btn-primary form-control" id="btn_exp" type="submit" >PDF</button> </div-->
<div class="row">
  <form id="combinedForm" name="combinedForm" method="post">
    <input type="hidden" name="sacd_yer" value="<?=$pdata['acd_yer']?>" />
    <input type="hidden" name="ssch_id" value="<?=$pdata['sch_id']?>" />
    <input type="hidden" name="scurs" value="<?=$pdata['curs']?>" />
    <input type="hidden" name="sstrm" value="<?=$pdata['strm']?>" />
    <input type="hidden" name="ssem" value="<?=$pdata['sem']?>" />
    <input type="hidden" name="sdivis" value="<?=$pdata['divis']?>" />
    <input type="hidden" name="sfdt" value="<?=$pdata['fdt']?>" />
    <input type="hidden" name="stdt" value="<?=$pdata['tdt']?>" />
    <input type="hidden" name="srtyp" value="<?=$pdata['rtyp']?>" />
    <input type="hidden" name="sub_type" value="<?=$pdata['sub_type']?>" />
    <div class="col-sm-1"> <button class="btn btn-primary form-control" type="button" onclick="submitForm('pdf')">PDF</button> </div>
    <div class="col-sm-1"> <button class="btn btn-primary form-control" type="button" onclick="submitForm('excel')">Excel</button> </div>
  </form>
</div>

  </form>
</div>
  <?php } if($exp=='Y'){ ?>
  <div class='table-responsive'>
  <table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
    <td align="center">
    <img src="https://erp.sandipuniversity.com/assets/images/logo_form.png" width="200" />
    <p style="margin-top:0"><strong>Mahiravani, Trimbak Road, Nashik – 422 213</strong><br> 

    </td>
  </tr>
</table>
<?php } ?>
<div style="text-align:center;color:red;"><h4><b>Attendance Mark Report</b></h4></div>
  <table id="dis_data" class="table table-bordered" border='1' style="border-color:#249f8a;" cellpadding="5" cellspacing="5">
                         <?php
                            //print_r($sdate);
                         //   echo"<pre>";print_r($timtab);echo"</pre>";
						 $acd_yer =$this->config->item('current_year');
						 $acd_sess =$this->config->item('current_sess');
						 $CI =& get_instance();
								$CI->load->model('Student_attendance_model');
                            if(!empty($timtab)){
								?>
                            <tr>
<td colspan="11" align="center" style="align:center;" ><H4><b>Current Session: <?=$this->config->item('current_year')?>(<?php if($this->config->item('current_sess')=='WIN'){ echo 'WINTER'; }else{ echo 'SUMMER'; }?>)</b></h4></td>
 </tr>
 <tr>
  <td colspan="11" align="left" style="background-color:#6BCEEF;padding:10px;">&nbsp;<b>From Date: </b>&nbsp;<?=$fdate?>&nbsp; | &nbsp;<b>To Date:</b>&nbsp;<?=$tdate?></td></tr>
  
<tr style="background-color:#D2D2D2;"> <th align="center"><b>Sr.no</b></th><th  align="center"><b>School</b></th><th  align="center"><b>Course</b></th><th  align="center"><b>Stream</b></th><th  align="center"><b>Year</b></th><th  align="center"><b>Class Strength</b></th><?php if($sub_type!=''){ ?><th  align="center"><b>Type</b></th><?php }?><th  align="center"><b>No Of lecture Assigned</b></th><th  align="center"><b>No of lecture taken</b></th>
<th  align="center"><b>Present %</b></th>
<th  align="center"><b>Absent %</b></th>
</tr>
  <?php
                                $j=1;                             
                           $p=0; $t=0;
                            $kk=array();
                           $cntj=count($timtab);                          
                            $k=1;
                            // echo $stud_list[2]['called_by'];
                          for($i=0;$i<$cntj;$i++){  
						  $attper=$CI->Student_attendance_model->get_attendance_percentage_for_mark_report($timtab[$i]['stream_id'],$acd_yer, $acd_sess, $fdate,$tdate,$timtab[$i]['semester']);
						  $totalcount=$CI->Student_attendance_model->get_totstudentcount($timtab[$i]['stream_id'],$acd_yer, $acd_sess,$timtab[$i]['semester']);
						//print_r($totalcount);
							if($t=='r'){
							  $t= $timtab[$i-1]['school_short_name'];
							}else{
							  $t  = $timtab[$i]['school_short_name'];
							}
							$p_per=bcdiv($attper[0]['p_per'],1,2);
							if($p_per <=50){
								$style_per ='style="background-color:#ff0000;color: white;font-weight: bold;"';
							}else{
								$style_per ="";
							}
                            ?>
                            <tr>
                             <td><?=$k?></td> 
                                  <td><b><?php
								  if($timtab[$i]['school_short_name']!=$t){
									 echo $timtab[$i]['school_short_name']; 
								  }else{
									  
								  }
								  ?></b></td> 
                                <td><?=$timtab[$i]['course_short_name']?></td> 
                                <td><?=$timtab[$i]['stream_name']?></td>
                                <td><?php
									if($timtab[$i]['semester']==1 || $timtab[$i]['semester']==2){
										$yer="First Year";
									}else if($timtab[$i]['semester']==3 || $timtab[$i]['semester']==4){
										$yer="Second Year";
									}else if($timtab[$i]['semester']==5 || $timtab[$i]['semester']==6){
										$yer="Third Year";
									}else if($timtab[$i]['semester']==7 || $timtab[$i]['semester']==8){
										$yer="Fourth Year";
									}else if($timtab[$i]['semester']==9 || $timtab[$i]['semester']==10){
										$yer="Fifth Year";
									}else{
										$yer='';
									}
									echo $yer;
								?></td>
								<td><?=$totalcount[0]['no_of_students']?></td>
								<?php if($sub_type!=''){ ?>
                                <td><?php if($sub_type=='TH'){ echo $sub_type;}elseif($sub_type=='PR'){echo $sub_type;}else{ echo "-";}?></td>
								<?php }?>
                                <td><?=$timtab[$i]['no_of_lectures']?></td>
								<td><?php 
								//if(!empty($timtab[$i]['no_of_reregistered'])){
									echo $timtab[$i]['no_lecture_taken'];
								/*}else{
									echo "Re-registration not-done";
								}*/
								?></td>
                                 <td><center><p <?=$style_per?>><?=bcdiv($attper[0]['p_per'],1,2)?></p></center></td>
								<td><?=bcdiv($attper[0]['a_per'],1,2)?></td>
                            </tr>

                           <?php                             
                            
                        $k++;

                          $t= 'r';

                          $y='';
							}}
               
                            ?>    
                            </tbody>
                          </table>              
                           
       
<script>
  function submitForm(format) {
    var form = document.getElementById("combinedForm");
    
    // Set action based on the button clicked
    if (format === 'pdf') {
      form.action = "<?= base_url($currentModule . '/stud_attendance_mark_report_download') ?>";
    } else if (format === 'excel') {
      form.action = "<?= base_url($currentModule . '/stud_attendance_mark_report_excel_download') ?>";
    }    
    // Submit the form
    form.submit();
  }
</script>