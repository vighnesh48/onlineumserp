<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<META http-equiv="Content-Type" content="text/html; charset=utf-8">
<!--<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">-->
<link href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css' rel='stylesheet' id='bootstrap-css'>
<script src='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js'></script>
<script src='https://code.jquery.com/jquery-1.11.1.min.js'></script>
<!------ Include the above in your HEAD tag ---------->

<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js'></script>
<script src='http://getbootstrap.com/dist/js/bootstrap.min.js'></script>
<style>
<style type="text/css">
.row {
margin: 12px 0px 0px 0px !important;
padding: 0px !important;
}
.col-xs-1, .col-sm-1, .col-md-1, .col-lg-1, .col-xs-2, .col-sm-2
, .col-md-2, .col-lg-2, .col-xs-3, .col-sm-3, .col-md-3, .col-lg-3
, .col-xs-4, .col-sm-4, .col-md-4, .col-lg-4, .col-xs-5, .col-sm-5
, .col-md-5, .col-lg-5, .col-xs-6, .col-sm-6, .col-md-6, .col-lg-6
, .col-xs-7, .col-sm-7, .col-md-7, .col-lg-7, .col-xs-8, .col-sm-8
, .col-md-8, .col-lg-8, .col-xs-9, .col-sm-9, .col-md-9, .col-lg-9
, .col-xs-10, .col-sm-10, .col-md-10, .col-lg-10, .col-xs-11, .col-sm-11
, .col-md-11, .col-lg-11, .col-xs-12, .col-sm-12, .col-md-12, .col-lg-12 {
	border:0 !important;
	padding:0 !important;
	margin-left:-0.00005 !important;
}
table td{ font-size:12px;}
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
		<td width="80" align="center" style="padding-top:5px;text-align:right;" rowspan="2">
			<span style="font-size: 20px;"><b>COE</b></span>
		</td>
	</tr>
	<tr>
		<td align="center" style="text-align:center;padding-top:2px;">
		<h3 style="font-size:14px;">OFFICE OF THE CONTROLLER OF EXAMINATIONS<br>
		<u style="font-size:13px;">CGPA REPORT </u></h3>
		</td>
	</tr>      
 </table>
 
 <table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;">
                <tr>
<th  height="30" valign="middle">&nbsp;<strong>Regulation:</strong></th>
<td height="30" valign="middle">&nbsp; <?=$regulation?></td>
<th  height="30" valign="middle">&nbsp;<strong>Exam Session:</strong> </th>
<td  height="30" valign="middle" >&nbsp;<?php 
  //$exam= explode('-', $_POST['exam']);
	   //     $exam_month =$exam[0];
	   //     $exam_year =$exam[1];
echo $exam_month.''.$exam_year;?> </td>


</tr>
<tr>
<th  height="30">&nbsp;<strong>School Name:</strong></th>
<td height="30" >&nbsp;<?=strtoupper($stud_list[0]['school_short_name'])?></td>
<th  height="30" valign="middle">&nbsp;<strong>Course Name:</strong> </th>
<td  height="30" valign="middle">&nbsp;<?=strtoupper($stud_list[0]['course_short_name'])?> </td>
</tr>


<tr>
<th  height="30">&nbsp;<strong>Stream Name:</strong></th>
<td height="30">&nbsp;<?=strtoupper($stud_list[0]['stream_name'])?></td>
<th height="30" valign="middle">&nbsp;Semester </th>
<td height="30" valign="middle">&nbsp;<?=strtoupper($stud_list[0]['semester'])?><strong></strong> </td>       
</tr>

             </table>
<table class="table table-bordered" id="table2excel">
                        <thead>
                            <tr>
                                  
                                    <th>S.No.</th>
									
                                    <th>PRN</th>
                                    <th>Student Name</th>
									
                                    <th>CGPA</th>
                                    <th>Attempt(Yes/No)</th>
                                    <th>No.Arrears</th>

                                    
                            </tr>
                        </thead>
                            <tbody id="studtbl">
                        	<input type="hidden" name="semester" id="ressemester" value="<?=$semester?>">
                        	<input type="hidden" name="school" value="<?=$school_code?>">
                        	<input type="hidden" name="stream_id" id='resstream_id' value="<?=$stream?>">
                            <input type="hidden" name="regulation" id='regulation' value="<?php echo $_REQUEST['regulation'];?>">
                        	<input type="hidden" name="exam_session" id="resexam_session" value="<?=$exam_month.'~'.$exam_year.'~'.$exam_id?>">
                            <?php
                            //echo "<pre>";
							//print_r($stud_list);
                          
                            $j=1;                            
                            for($i=0;$i<count($stud_list);$i++)
                            {
                            ?>
	
							 
                            <tr>
							
                              <td><?=$j?></td>
                        		
                                <td align="center">&nbsp;<?=$stud_list[$i]['enrollment_no']?>&nbsp;</td> 
                                <td align="center">&nbsp;<?=$stud_list[$i]['stud_name'];?>&nbsp;</td> 	
							 	
                                <td align="center">&nbsp;<?php if(($stud_list[$i]['checb']==0)){ echo $stud_list[$i]['cumulative_gpa'];}else{ echo '-';}?>&nbsp;</td> 	
                                <td align="center">&nbsp;<?php if(($stud_list[$i]['checb']==0)){echo 'No';}else{echo'Yes';} ?>&nbsp;</td> 	
                                <td align="center">&nbsp;<?php  echo $stud_list[$i]['checb']; ?>&nbsp;</td> 									
                            </tr>
                            <?php
                            $j++;
                            }
							 $dattime = date('d-m-Y H:i:s');
                            ?>                            
                        </tbody>
                    </table>
                    <br><br>
                    <table width="100%" border="0" cellspacing="5" cellpadding="5" align="center" style="margin-bottom:40px;"><tr><th width="30%" style="float:right">&nbsp;&nbsp;<b>COE Sign</b></th><td width="40%"></td><td width="10%" style="float:right"></td><th width="40%" style="float:right"><b>Printed on: <?php echo $dattime;?></b> </th></tr></table>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</body></html>