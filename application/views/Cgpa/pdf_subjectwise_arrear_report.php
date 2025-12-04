<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>ARREARS REPORT</title>
    <style>  
            table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:12px; xmargin:0 auto;
            }  
      td{vertical-align: top;}
                      
            .signature{
            text-align: center;
            }
            .marks-table{
            width: 100%;xxheight:650px;
            }
            p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
            .marks-table td{height:30px;vertical-align:middle;}
            .marks-table th{height:30px;}
.content-table tr td{border:1px solid #333;vertical-align:middle;}
.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;}
.content-table td{padding-left:8px;}
        </style>  

</head>




<body>
<table cellpadding="0" cellspacing="0" border="0" align="center" width="800">
	<tr>
		<td width="80" align="center" style="text-align:center;padding-top:5px;" rowspan="2"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
		<td style="font-weight:normal;text-align:center;">
			<h1 style="font-size:30px;">Sandip University</h1>
			<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>
		</td>
		<td width="120" align="right" valign="top" style="text-align:right;" rowspan="2">
			<span style="font-size: 20px;"><b>COE</b></span>
		</td>
	</tr>
	<tr>
		<td align="center" style="text-align:center;padding-top:2px;">
		<h3 style="font-size:14px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>
		<u style="font-size:13px;">SUBJECTWISE ARREAR REPORT - <?=$exam_month?> <?=$exam_year?></u></h3>
		</td>
	</tr>      
 </table>
 <hr>
<?php
 $CI =& get_instance();
$CI->load->model('Results_model');
//echo "<pre>";
//print_r($stream_list);
if($report_type=="subjectwise"){
foreach ($stream_list as $value) {
?>	           

            <table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
			<tr>
            <td  width="15%" valign="middle">&nbsp;<strong>Program:</strong></td>
            <td valign="middle" colspan='3'>&nbsp;<?=$value['stream_name']?></td>
            </tr>
             </table>
          
            <table class="content-table" border="1">
                        <thead>
                            <tr>
                                    <th>S.No.</th>
                                    <th>Course Code</th>    
                                    <th>Semester</th>
                                     <th>Course Name</th>
                                     <th>No. of Arrear(s) </th>           
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        <?php 
                        $result_data = $school_code.'~'.$stream.'~'.$exam_month.'~'.$exam_year.'~'.$exam_id;
                        ?>
                              <input type="hidden" id="res_data" name="res_data" value="<?=$result_data?>">

                            <?php
                           //echo "<pre>";
                            //print_r($subject_list);
                            //$enrollment_no='';
                            $i=0; 
                            $j=1;
                            if(!empty($value['subject_list'])){                          
                            foreach ($value['subject_list'] as $val) {
                               $sub_stud =$this->Results_model->fetch_arrear_students($value['stream_id'], $val['subject_id'],$exam_id);
                            ?>              
                            <tr>
                              <td align="center" width="10%" rowspan="2"><?=$j?></td>
                                <td align="center" width="10%"><?=$val['subject_code']?></td> 
                                <td align="center" width="10%"><?=$val['semester']?></td> 
                                <td><?=$val['subject_name']?></td>
                                <td align="center" width="15%"><?=count($sub_stud);?></td> 
    
                            </tr>
                            <?php
                            foreach ($sub_stud as $stud) {
                               //echo $value['isPresent']; 
                                $enrollment_no[] = $stud['enrollment_no'];
                            } ?>
                            <tr> 
                              <td colspan=4 style="word-wrap: break-word;"><?=implode(', ', $enrollment_no);?></td>     
                            </tr>
                            <?php
                            $j++;
                            $i++;
                            unset($enrollment_no);
                            }
                        }else{
                            echo "<tr><td colspan='6'>No data found.</td></tr>";
                        }
                            ?>                            
                        
                        </tbody>
                    </table> 
					<br>
            
<?php } 
}else{?>
            <table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
			<tr>
            <td height="30" valign="middle">&nbsp;<strong>Program:</strong></td>
            <td height="30" valign="middle" colspan='3'>&nbsp;<?=$StreamSrtName[0]['stream_name']?></td>
            <!--<td width="120" height="30" valign="middle">&nbsp;<strong>Stream:</strong></td>-->
            <!--<td height="30" valign="middle">&nbsp;<?=$StreamSrtName[0]['stream_short_name']?></td>-->
            </tr>
             </table>
            
            <table class="content-table">
                        <thead>
                            <tr>
                                    <th>S.No.</th>
                                    <th>Course Code</th>    
                                    <th>Semester</th>
                                     <th>Course Name</th>
                                     <th>No. of Arrear(s) </th>           
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        <?php 
                        $result_data = $school_code.'~'.$stream.'~'.$exam_month.'~'.$exam_year.'~'.$exam_id;
                        ?>
                              <input type="hidden" id="res_data" name="res_data" value="<?=$result_data?>">

                            <?php
                           //echo "<pre>";
                            //print_r($subject_list);
                            //$enrollment_no='';
                            $i=0; 
                            $j=1;
                            if(!empty($subject_list)){                          
                            foreach ($subject_list as $key => $value) {
                               //echo $value['isPresent']; 
                            ?>              
                            <tr>
                              <td align="center" width="10%"><?=$j?></td>
                                <td align="center" width="10%"><?=$value['subject_code']?></td> 
                                <td align="center" width="10%"><?=$value['semester']?></td> 
                                <td><?=$value['subject_name']?></td>
                                <td align="center" width="15%"><?=count($subject_list[$i]['stud_sub_applied']);?></td>
    
                            </tr>
                            <?php
                            foreach ($subject_list[$i]['stud_sub_applied'] as $stud) {
                               //echo $value['isPresent']; 
                                $enrollment_no[] = $stud['enrollment_no'];
                            } ?>
                            <tr>
                                <td></td>
                              <td colspan=5 style="word-wrap: break-word;"><?=implode(', ', $enrollment_no);?></td>     
                            </tr>
                            <?php
                            $j++;
                            $i++;
                            unset($enrollment_no);
                            }
                        }else{
                            echo "<tr><td colspan='6'>No data found.</td></tr>";
                        }
                            ?>                            
                        
                        </tbody>
                    </table>
<?php }?>					
</body>
</html>
