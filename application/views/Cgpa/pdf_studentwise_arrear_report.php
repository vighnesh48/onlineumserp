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
		<u style="font-size:13px;">STUDENTWISE ARREAR REPORT - <?=$exam_month?> <?=$exam_year?></u></h3>
		</td>
	</tr>      
 </table>
 <hr>
<?php
 $CI =& get_instance();
$CI->load->model('Results_model');
//echo "<pre>";
//print_r($stream_list);

foreach ($stream_list as $value) {
?>	
<table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
    <tr>
        <td height="30" width="15%" valign="middle">&nbsp;<strong>Program:</strong></td>
        <td height="30" valign="middle" colspan='3'>&nbsp;<?=$value['stream_name']?></td>
    </tr>
</table>

<table class="content-table" border="1">
    <thead>
        <tr>
            <th>S.No.</th>
            <th>PRN</th>    
            <th>Name</th>
            <th>Sem</th> 
            <th>Course Code</th>
            <th>Course Name</th>
            <th>No. of arrear(s)</th>        
        </tr>
    </thead>
    <tbody id="studtbl">
        <?php
        //echo "<pre>";
        // print_r($student_list);exit;
        //$enrollment_no='';
        $i=0; 
        $j=1;
        $k=1;
        if(!empty($value['student_list'])){                          
        foreach ($value['student_list'] as $val) {
			$stud_sub_applied= $this->Results_model->stud_arrear_subject_list($value['stream_id'], $val['student_id'],$batch,$exam_id='');
            $cnt_sub = count($stud_sub_applied);
           //$cnt_sub = $cnt_sub+1;
        ?>              
        <tr >
          <td rowspan="<?=$cnt_sub?>" align="center" ><?=$j?></td>
            <td rowspan="<?=$cnt_sub?>" align="center"><?=$val['enrollment_no']?></td> 
            <td rowspan="<?=$cnt_sub?>"><?=$val['stud_name']?></td> 
            <td align="center"><?=$stud_sub_applied[0]['semester']?></td>
            <td align="center"><?=$stud_sub_applied[0]['subject_code']?></td>
            <td><?=$stud_sub_applied[0]['subject_name']?></td> 
            <td rowspan="<?=$cnt_sub?>" align="center"><?=count($stud_sub_applied);?></td>    
        </tr>
        <?php 
            //foreach ($student_list[$i]['stud_sub_applied'] as $sub) {
            for($k=1; $k < $cnt_sub; $k++){    
            ?>
            <tr>
                <td align="center"><?=$stud_sub_applied[$k]['semester']?></td>
                <td align="center"><?=$stud_sub_applied[$k]['subject_code']?></td>
                <td><?=$stud_sub_applied[$k]['subject_name']?></td>
            </tr>
                <?php 
                   }
                ?>
        <?php

        $j++;
        $i++;
        }
    }
     ?>                            
    </tbody>
    </table> <br>
   <?php
    }
     ?>        
</body>
</html>
