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
/*table td{ font-size:12px;}*/
</style> <style>  
    
            table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:12px; margin:0 auto;
            }  
      td{vertical-align: top;}
                      
            .signature{
            text-align: center;
            }
            .marks-table{
            width: 100%;height:650px;
            }
            p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
            .marks-table td{height:30px;vertical-align:middle;}
			
            .marks-table th{height:30px;}
.content-table td{border:1px solid #333;padding-left:5px;vertical-align:middle; padding:2px; font-size:13px;}
.content-table th{border-left:1px solid #333;border-right:1px solid #333;border-bottom:1px solid #333;
 padding:2px;font-size:14px !important;}
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
		<h3 style="font-size:14px;">End Semester Examination Valuation- <?=$exam_month;?>-<?php echo $exam_year; ?><br><br>
		<u style="font-size:13px;"><b style="font-weight: bold;">SCRIPT DETAILS</b></u></h3>
		</td>
	</tr>      
 </table>
 <table><tr>  <td style="padding-top:2px; margin-left:50px;"><b style="font-weight:700;">Board Name</b>:<b style="font-weight: bold;"><?=$stud_list[0]['evaluation_board']?></b></td></tr></table>
 <br>
<table border="1" class="content-table" id="table2excel" cellspacing="5" cellpadding="5">
                         
              
                        <thead>
                               

 
                             
                            <tr>
                                 
                                    <th align="center" width="3%">&nbsp;S.No&nbsp;</th>
                                    <th align="center" width="5%">&nbsp;Batch&nbsp;</th>
                                    <th align="center" width="5%">&nbsp;Stream&nbsp;</th>
                                    <th align="center" width="3%">&nbsp;Sem&nbsp;</th>
                                    <th align="center" width="10%">&nbsp;Course&nbsp;Code&nbsp;</th>
                                    <th align="center" width="40%">&nbsp;Course&nbsp;Name&nbsp;</th>
                                    
                                    
                                    <th align="center" width="5%">&nbsp;Date&nbsp;</th>
                                    <th align="center" width="8%">&nbsp;session&nbsp;</th>
                                    <th align="center" width="10%">&nbsp;Applied&nbsp;</th>
                                    <th width="5%">&nbsp;Appeared&nbsp;&nbsp;</th>
                                   <th align="center" width="15%">&nbsp;&nbsp;Valuator&nbsp;&nbsp;&nbsp;</th>
                                    

                                    
                            </tr>
                        </thead>
                        <tbody id="studtbl">
                        	
                            <?php
                            //echo "<pre>";
							//print_r($stud_list);
                          
                            $j=1;  $Honours='0'; $Distinction='0';  $FirstClass='0';     $SecondClass='0';   $ThirdClass='0';                
                            for($i=0;$i<count($stud_list);$i++)
                            {
								if(!empty($stud_list[$i]['couser_code'])){
									if($stud_list[$i]['Appear']==0){
											$color="";
									}else{
									
										$color="#99CCCC";
									}
                            ?>
	
							 
                            <tr bgcolor="<?php echo $color; ?>">
						
                              <td align="left" >&nbsp;<?=$j?>&nbsp;</td>
                               <td align="left">&nbsp;<?php if($stud_list[$i]['batch']){
									if(empty($batchname)){
									echo "<b>".$stud_list[$i]['batch']."<b>";
										$batchname[]=$stud_list[$i]['batch'];
									}else{
									if($stud_list[$i]['batch']==$stud_list[$i+1]['batch']){
										echo '-';
									}else{
										echo '-';
										unset($batchname);
									}
									}
								}
								
								?>&nbsp;</td>
                                  <td align="left">&nbsp;<?=$stud_list[$i]['stream_short_name']?>&nbsp;</td>
                                 <td align="left">&nbsp;<?=$stud_list[$i]['semester']?>&nbsp;</td> 
                                <td align="left">&nbsp;<?=$stud_list[$i]['couser_code']?>&nbsp;</td> 
                                <td align="left">&nbsp;<?=$stud_list[$i]['subject_name'];?>&nbsp;</td> 	
                                <td align="left">&nbsp;<?= date("d/m/Y", strtotime($stud_list[$i]['date']))?>&nbsp;</td>
                               <td align="center">&nbsp;<?php //$stud_list[$i]['from_time'];
							   if($stud_list[$i]['from_time']=='09:30:00'){
			echo $ses = 'F.N';
		}else{
			echo $ses = 'A.N';
		}
							   
							   ?>&nbsp;</td>
              <td align="center">&nbsp;<?php $Applied +=$stud_list[$i]['Applied']; echo $stud_list[$i]['Applied'];?>&nbsp;</td>
              <td align="center">&nbsp;<?php $Appear +=$stud_list[$i]['Appear']; echo $stud_list[$i]['Appear'];?>&nbsp;</td>	
							
                                
                                
                                
                             <td>&nbsp;</td>				
                            </tr>
                            <?php
                            $j++;
								}}
                            ?>  
                        <tr>
                         <th align="center"></th>
                                    <th align="center"></th>
                                    <th align="center"></th>
                                    <th align="center"></th>
                                    <th align="center"></th>
                                    <th align="center" colspan="3">&nbsp;Total Scripts&nbsp;</th>
                                    
                                    
                                    
                                    <th align="left">&nbsp;<?php echo $Applied; ?>&nbsp;</th>
                                   <th align="center"><?php echo $Appear; ?></th>
                                   <th align="center"></th>
                        </tr>
                       
                     


</tbody> 
</table>
                    <br><br>
                    <table width="100%" border="0" cellspacing="5" cellpadding="5" align="center" style="margin-bottom:40px;"><tr><th width="30%" style="float:right">&nbsp;&nbsp;<b>Board Chairman Sign</b></th><td width="40%"></td><td width="10%" style="float:right"></td><th width="40%" style="float:right"><b> <?php  echo date('Y-m-d');?></b> </th></tr></table>
                    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
</body></html>