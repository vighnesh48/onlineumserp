
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
 <?php if($exp !='Y'){ 
//print_r($pdata);
    ?>
    <style>
    .row { font-family:"Arial Verdana"; }
    .table{ padding:10px;font-family:"Arial Verdana important"; }
    </style>
   

  <form id="form1" name="form1" action="<?= base_url($currentModule . '/faculty_rep_download1') ?>" method="post">
<input type="hidden" name="sacd_yer" value="<?=$pdata['acd_yer']?>" />
<input type="hidden" name="ssch_id" value="<?=$pdata['sch_id']?>" />
<input type="hidden" name="scurs" value="<?=$pdata['curs']?>" />
<input type="hidden" name="sstrm" value="<?=$pdata['strm']?>" />
<input type="hidden" name="sfctl" value="<?=$pdata['fctl']?>" />

<input type="hidden" name="sfdt" value="<?=$pdata['fdt']?>" />
<input type="hidden" name="stdt" value="<?=$pdata['tdt']?>" />

<div class="col-sm-1"> <button class="btn btn-primary form-control" id="btn_exp" type="submit" >PDF</button> </div>
  </form>
  
  
<!-- <input type="button" value="Print Div Contents" id="btnPrint" /> 
-->  
</div>
  <?php } ?>

  <style type="text/css">
.table-bordered, .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th
{ border-color:#8acc82;}
  </style> 
  <?php if($exp =='Y'){ ?>
    
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  <tr>
    <td align="center">
    <img src="http://erp.sandipuniversity.com/assets/images/logo_form.png" width="200" />
    <p style="margin-top:0"><strong>Mahiravani, Trimbak Road, Nashik – 422 213</strong><br> 

    </td>
  </tr>
</table>
<?php } ?>
<div style="text-align:center;color:red;padding-top:5px;padding-bottom:0px;font-size:15px;"><b><?=$school_name_h?></b></div>
<div style="text-align:center;color:red;padding-top:5px;font-size:13px;"><b>Faculty Report</b></div>
  <table id="dis_data" class="table table-bordered" border='1'  style="border-collapse: collapse; border-color: #249f8a;" id="pdf_print">
  
                        
                         <?php
                            //print_r($sdate);
                       //   echo"<pre>";print_r($sublist);echo"</pre>"; exit;
                            if(!empty($sublist)){ ?>
                            <tr>
<td colspan="12" align="center" style="align:center;" style="padding:10px;" ><H4><b><?=$school_name?></b></H4><b>Current Session: <?=$this->config->item('current_year')?>(<?php if($this->config->item('current_sess')=='WIN'){ echo 'WINTER'; }else{ echo 'SUMMER'; }?>)</b></td>
  </tr>
  <?php
                                $j=1;                             
                           $p=0; $t=0;
$kk=array();
                           $cntj=count($sublist);                          
                            
                            // echo $stud_list[2]['called_by'];
                          for($i=0;$i<$cntj;$i++){  
             // echo '<br>';
//echo "gg";
if($t=='r'){
  $t= $i-1;
}else{
  $t  = $t;
}
$acd_yr = explode('~',$pdata['acd_yer']);
 

if($sublist[$t]['faculty_code'] != $sublist[$i]['faculty_code'] ){
                         //   echo "</br>"; echo "done";
                         //   }else{

//if($cnt!='0'){
                            ?>
  <tr style="background-color:#6BCEEF;padding:10px;">
   <?php if($exp =='Y'){ ?>
  <td colspan="12" align="left" style="padding:10px;">&nbsp;<b>Faculty: </b>&nbsp;&nbsp; <?=$sublist[$i]['fname']." ".$sublist[$i]['lname']?>(<?=$sublist[$i]['faculty_code']?>)</td>
<?php }else{ ?>
<td colspan="10" align="left" style="padding:10px;">&nbsp;<b>Faculty: </b>&nbsp;&nbsp; <?=$sublist[$i]['fname']." ".$sublist[$i]['lname']?>(<?=$sublist[$i]['faculty_code']?>)</td>

<td align="center"><img src="<?=site_url()?>assets/images/duck2.png" width="30" height="30" /> </td>
<td align="center"  >
<span id="tdk_<?=$sublist[$i]['faculty_code']?>" style=" font-size:19px; color:red;"></span></td>
  
  <?php } ?>
  </tr>
<tr style="background-color:#D2D2D2;"> <th align="center" style="padding:10px;"><b>Sr.no</b></th><th  style="padding:10px;" align="center"><b>Day</b></th><th  style="padding:10px;" align="center"><b>School</b></th><th style="padding:10px;" align="center"><b>Stream</b></th><th style="padding:10px;" align="center"><b>Sem</b></th><th style="padding:10px;" align="center"><b>Div</b></th><th style="padding:10px;" align="center"><b>Subject Name</b></th><th  style="padding:10px;" align="center"><b>Type</b></th><th style="padding:10px;"  align="center"><b>Slot</b></th><th style="padding:10px;" align="center"><b>Present</b></th><th style="padding:10px;" align="center"><b>Absent</b></th><th style="padding:10px;" align="center"><b>Percentage</b></th>
</tr>

                       
<?php  $k=1; $y='1'; //}
  
   }  

foreach($sdl as $s){
$fdate = $s;
$tdate = $s;
   $rowa=$this->Student_Attendance_model->get_faculty_lecturs_fact_code($acd_yr[0],substr($acd_yr[1], 0,3),$sublist[$i]['faculty_code'],$fdate,$tdate);

    //print_r($rowa);             exit;             
  $cnt = count($rowa);

     if($cnt!='0'){



      for ($j=0;$j<$cnt;$j++) {
        # code...
         $dt= $sdate[$rowa[$j]['wday']];
        
         // $dt=
 $rowp=$this->Student_Attendance_model->get_student_attendance_data_duck($acd_yr[0],substr($acd_yr[1], 0,3),$fdate,$rowa[$j]['stream_id'],$rowa[$j]['semester'],$rowa[$j]['division'],$rowa[$j]['lecture_slot'],$sublist[$i]['faculty_code'],$rowa[$j]['batch']);

if(empty($rowp)){


$assign_f=$sublist[$i]['faculty_code'];
$taken_f=$rowp[0]['faculty_code'];
if($taken_f !=''){
if($taken_f!=$assign_f){ 
  $rs=2; 
  //$rs='';
}else{
  $rs='';
}
}else{
  $rs='';
}
      
                          ?>
                            <tr  >

                             <td rowspan="<?=$rs?>" align="center"><?=$k?></td> 
                              <td rowspan="<?=$rs?>"><?php 

                               if($z!=$rowa[$j]['wday']) {
echo $fdate; 
 $z = $rowa[$j]['wday'];
                                   }else{
                                       if($y == '1' ){
                                         echo $dt; 
                                       }
                                      
                                  }
                                 //echo $dt; echo "<br/>"; echo "(".$rowa[$j]['wday'].")";
                             ?></td> 
                             <td rowspan="<?=$rs?>" align="center"><?=$rowa[$j]['school_short_name']?></td>
                            
                              <td rowspan="<?=$rs?>">&nbsp;<?=$rowa[$j]['stream_name']?></td>
                              <td rowspan="<?=$rs?>" align="center"><?=$rowa[$j]['semester']?></td>
                               <td rowspan="<?=$rs?>" align="center"><?=$rowa[$j]['division']?></td>
                                 
                                <td rowspan="<?=$rs?>">&nbsp;<?php

if($rowa[$j]['subject_code']== 'OFF'){
                  echo "OFF Lecture";
                }else if($rowa[$j]['subject_code']=='Library'){
                  echo "Library";
                }else if($rowa[$j]['subject_code']== 'Tutorial'){
                  echo "Tutorial";
                }else if($rowa[$j]['subject_code']== 'Tutor'){
                  echo "Tutor";
                }else if($rowa[$j]['subject_code']== 'IS'){
                  echo "Internet Slot";
                }else if($rowa[$j]['subject_code']== 'RC'){
                  echo "Remedial Class";
                }else if($rowa[$j]['subject_code']== 'EL'){
                  echo "Experiential Learning";
                }else if($rowa[$j]['subject_code']== 'SPS'){
                  echo "Swayam Prabha Session";
                }else if($rowa[$j]['subject_code']== 'ST'){
                  echo "Spoken Tutorial";
                }else if($rowa[$j]['subject_code']== 'FAM'){
                  echo "Faculty Advisor Meet";
                }else{

                 echo $rowa[$j]['sub_code']." - ".$rowa[$j]['subject_name'];

                  } ?>

                                </td> 
                                  <td rowspan="<?=$rs?>" align="center"><?php  if($rowa[$j]['subject_type']=='TH'){
                $stype="Th";
              }else{
                $stype="PR";
              } 
echo $stype;
              ?></td>                                
                                <td rowspan="<?=$rs?>">&nbsp;<?=$rowa[$j]['from_time']."-".$rowa[$j]['to_time']?></td>
  <?php 
if($rs=='2'){
echo ' <td colspan="3" style="color:green;"><b>'.$rowp[0]['fname'].' '.$rowp[0]['lname'].'('.$taken_f.')</b></td>';
}else{ 



  ?>

  
<?php if($rowp[0]['tpresent']==''){ ?>
<td colspan="3" align="center">
<?php
 
 $lv =$this->Student_Attendance_model->check_leave($sublist[$i]['faculty_code'],$fdate);
$hd = $this->Student_Attendance_model->check_holidays($fdate,$sublist[$i]['staff_type']);
 
if($lv=='N' && $hd =='false'){
	
	// code by vighnesh check for  is_for_other_duty
	
		$is_for_other = $this->Student_Attendance_model->check_other_duty($sublist[$i]['faculty_code'],$fdate);
		$is_for_other_batch = $this->Student_Attendance_model->check_other_duty($sublist[$i]['faculty_code'],$fdate,$rowa[$j]['semester']);
		if(!empty($is_for_other)){
			echo $is_for_other->task_name;
	}
	else if(!empty($is_for_other_batch)){
		echo $is_for_other_batch->task_name;
	}
	else{
$df[$sublist[$i]['faculty_code']][]=1;
  ?>
<img src="<?=site_url()?>assets/images/duck1.png" width="40px" height="40px" /> 

	<?php } 
	
	
	}else{ 
if($hd=='true' || $hd=='RD'){
                 echo "<b>Holiday</b>";
}else{
                              echo "<b>Leave - ".$lv." </b>";
                            }

  }  ?>
</td>
<?php }else{ ?>
<td align="center"><b><?=$rowp[0]['tpresent']?></b></td>
                                <td align="center"><b><?=$rowp[0]['tapsent']?></b></td><td align="center"><b><?=$rowp[0]['percen_lecturs']?></b></td>

<?php } ?>

<?php } ?>
                                </tr>

                                <?php if($rs=='2'){ ?>
                            
 <tr>
   <td align="center"><b><?=$rowp[0]['tpresent']?></b></td>
                                <td align="center"><b><?=$rowp[0]['tapsent']?></b></td><td align="center"><b><?=$rowp[0]['percen_lecturs']?></b></td>
  </tr>
 <?php      
}
                                    
                            
                        $k++; $y='';  }
}
                   
                          $t= 'r';
                        
                          }else{

                            $p++;
                           
                            $t=$i-$p;
                           
                          }
                        }
                           if($exp =='Y'){ ?>

<tr ><td colspan='9' align='right' style="padding:10px;" ><b>Total No. Ducks:</b></td><td colspan='3' align='center' style='color:red;padding:10px;font-size:18px;'><b><?php echo count($df[$sublist[$i]['faculty_code']]); ?></b></td></tr>
                         <?php  }else{     ?>
                           <script type="text/javascript">
              // $( document ).ready(function() {

               $("#tdk_<?=$sublist[$i]['faculty_code']?>").html(<?php echo count($df[$sublist[$i]['faculty_code']]); ?>);
             //  });
               </script>           
                            <?php
                           
                                 }      

                          }
                        }
               
                            ?>    
                            </tbody>
                            </table>  
                             
                 
