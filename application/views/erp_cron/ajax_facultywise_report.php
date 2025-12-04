

 
  <style type="text/css">
.table-bordered, .table-bordered > tbody > tr > td, .table-bordered > tbody > tr > th, .table-bordered > tfoot > tr > td, .table-bordered > tfoot > tr > th, .table-bordered > thead > tr > td, .table-bordered > thead > tr > th
{ border-color:#8acc82;}
  </style> 

    
  <table width="100%" border="0" cellspacing="0" cellpadding="0"  >
  <tr>
    <td align="center">
    <img src="http://sandipuniversity.com/erp/assets/images/logo_form.png" width="200" />
    <p style="margin-top:0"><strong>Mahiravani, Trimbak Road, Nashik – 422 213</strong><br> 

    </td>
  </tr>
</table>

<div style="text-align:center;color:red;padding-top:5px;padding-bottom:0px;font-size:15px;"><b><?=$school_name_h?></b></div>
<div style="text-align:center;color:red;padding-top:5px;font-size:13px;"><b>Faculty Report</b></div>
  <table id="dis_data" class="table table-bordered" border='1' style="border-color:#249f8a;" id="pdf_print">
  
                        
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
$rowa=$this->Erp_cron_attendance_model->get_faculty_lecturs_fact_code($sublist[$i]['faculty_code'],$pdata['fdt'],$pdata['tdt']);

  //  print_r($rowa);             exit;             
  $cnt = count($rowa);


if($sublist[$t]['faculty_code'] != $sublist[$i]['faculty_code'] ){
                         //   echo "</br>"; echo "done";
                         //   }else{

if($cnt!='0'){
                            ?>
  <tr style="background-color:#6BCEEF;padding:10px;">
   
  <td colspan="12" align="left" style="padding:10px;">&nbsp;<b>Faculty: </b>&nbsp;&nbsp; <?=$sublist[$i]['fname']." ".$sublist[$i]['lname']?>(<?=$sublist[$i]['faculty_code']?>)</td>

  </tr>
<tr style="background-color:#D2D2D2;"> <th align="center" style="padding:10px;"><b>Sr.no</b></th><th  style="padding:10px;" align="center"><b>Day</b></th><th  style="padding:10px;" align="center"><b>School</b></th><th style="padding:10px;" align="center"><b>Stream</b></th><th style="padding:10px;" align="center"><b>Sem</b></th><th style="padding:10px;" align="center"><b>Div</b></th><th style="padding:10px;" align="center"><b>Subject Name</b></th><th  style="padding:10px;" align="center"><b>Type</b></th><th style="padding:10px;"  align="center"><b>Slot</b></th><th style="padding:10px;" align="center"><b>Present</b></th><th style="padding:10px;" align="center"><b>Absent</b></th><th style="padding:10px;" align="center"><b>Percentage</b></th>
</tr>

                       
<?php  $k=1; $y='1'; }
  
   }  
     if($cnt!='0'){

      for ($j=0;$j<$cnt;$j++) {
        # code...
         $dt= $sdate[$rowa[$j]['wday']];
        
         // $dt=
  $rowp=$this->Erp_cron_attendance_model->get_student_attendance_data_pre($this->config->item('current_year'),$this->config->item('current_sess'),$dt,$rowa[$j]['stream_id'],$rowa[$j]['semester'],$rowa[$j]['division'],$rowa[$j]['lecture_slot']);


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
echo $dt; 
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

                 echo $rowa[$j]['sub_code']." - ".$rowa[$j]['subject_short_name'];

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
 
 $lv =$this->Erp_cron_attendance_model->check_leave($sublist[$i]['faculty_code'],$dt);
$hd = $this->Erp_cron_attendance_model->check_holidays($dt,$sublist[$i]['staff_type']);
 
if($lv=='N' && $hd =='false'){
$df[$sublist[$i]['faculty_code']][]=1;
  ?>
<img src="<?=site_url()?>assets/images/duck1.png" width="40px" height="40px" /> 

 <?php }else{ 
if($hd=='true' || $hd=='RD'){
                 echo "<b>Holiday</b>";
}else{
                              echo "<b>Leave - ".$lv." </b>";
                            }

  }  ?>
</td>
<?php }else{ ?>
<td align="center"><?=$rowp[0]['tpresent']?></td>
                                <td align="center"><?=$rowp[0]['tapsent']?></td><td align="center"><?=$rowp[0]['percen_lecturs']?></td>

<?php } ?>

<?php } ?>
                                </tr>

                                <?php if($rs=='2'){ ?>
                            
 <tr>
   <td align="center"><?=$rowp[0]['tpresent']?></td>
                                <td align="center"><?=$rowp[0]['tapsent']?></td><td align="center"><?=$rowp[0]['percen_lecturs']?></td>
  </tr>
 <?php      
}
                                    
                            
                        $k++; $y='';  }
                   
                          $t= 'r';
                        
                          }else{

                            $p++;
                           
                            $t=$i-$p;
                           
                          }
                          ?>

<tr ><td colspan='9' align='right' style="padding:10px;" ><b>Total No. Ducks:</b></td><td colspan='3' align='center' style='color:red;padding:10px;font-size:18px;'><b><?php echo count($df[$sublist[$i]['faculty_code']]); ?></b></td></tr>
                                
                            <?php
                           
                                // }      

                          }
                        }
               
                            ?>    
                            </tbody>
                            </table>  
                             
                 
