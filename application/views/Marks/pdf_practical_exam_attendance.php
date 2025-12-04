<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>PRACTICAL EXAMINATION REPORT</title>
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
		<u style="font-size:13px;">PRACTICAL EXAMINATION ATTENDANCE SHEET - <?=$exam_ses?></u></h3>
		</td>
	</tr>      
 </table>
 <hr>
           
				<?php 	
				$CI =& get_instance();
                $CI->load->model('Marks_model');
				?>
<?php
  if(!empty($sub_list)){

	$str_prn1='';
	$str_prn ='';
	foreach($sub_list as $sub){
	   
	   $subdata =$this->Marks_model->fetch_sub_batch_details($sub['sub_id'],$sub['stream_id'],$sub['semester'],$sub['batch'],$sub['academic_year'],$sub['academic_session']);
		foreach($subdata as $bth){
	   $studstrength =$this->Marks_model->fetch_student_strength($sub['sub_id'],$sub['stream_id'],$sub['semester'],$sub['division'],$bth['batch_no']);
	  //echo "<pre>"; print_r($studstrength);exit;
	?>
 <table class="content-table" border="1" align="center" style="font-size:12px;margin-top:10px;margin-bottom:10px">
				<tr>
				<td width="100" >&nbsp;<strong>Subject Code:</strong></td>
				<td >&nbsp;<?=strtoupper($sub['subject_code'])?>-<?php echo strtoupper($sub['subject_name']);?></td>
				<td width="80" height="30">&nbsp;<strong>Batch:</strong> </td>
				<td >&nbsp;<?=$bth['batch_no']?></td>

							
				</tr>
						   
				<tr>
				<td valign="middle">&nbsp;<strong>Date:</strong></td>
				<td valign="middle">&nbsp;</td>
				<td valign="middle">&nbsp;<strong>Division:</strong></td>
				<td valign="middle">&nbsp;<?=$sub['division']?></td>
				</tr>
				<tr>
				<td width="100" height="30" valign="middle">&nbsp;<strong>Stream:</strong></td>
				<td  valign="middle">&nbsp;<?=$sub['stream_name']?></td>
				<td width="80" height="30" valign="middle">&nbsp;<strong>Semester</strong> </td>
				<td height="30" valign="middle">&nbsp;<?=$sub['semester']?></td>
						   
				</tr>
				</table>					
				<table class="content-table" border="1">
                        <thead>
                            <tr>
                                    <th>S.No.</th>
                                    <th>PRN</th>
                                    <th>Student Name</th>
									<th>Ans.Booklet No</th>
									<th>Candidate.Sign</th>                                
                            </tr>
                        </thead>
                        <tbody>
					
						<?php
						$j=1;
							foreach($studstrength as $stud){
								//echo $stud['first_name'];exit;
						?>
							<tr>
							  <td align="center" ><?=$j?></td>
							  <td><?php echo strtoupper($stud['enrollment_no']);?></td> 
							  <td align="center"><?=strtoupper($stud['first_name'].' '.$stud['middle_name'].' '.$stud['last_name'])?></td> 
							  <td></td> 
							  <td align="center"></td>	  
							</tr>

                            <?php
                            $j++;
							
							
                            }unset($j);
							
							?> </tbody>
                    </table><?php
						  }
						  
	}

 }if(!empty($bksub_list)){ ?>					
					<div><h6><b>Back-Log Subjects:</b></h6></div>
				<table class="content-table" border="1">
                        <thead>
                            <tr>
							<th>S.No.</th>
							<th>Subject Code</th>
							<th>Subject Name</th>
							<th>Division</th>
							<th>Batch</th>
							<th>Timing</th>
							<th>Strength</th>
							<th>Reg. Numbers</th>
							<th>Venue</th>         
                            </tr>
                        </thead>
                      <tbody id="studtbl">
                            <?php
                          if(!empty($bksub_list)){
                            $j=1;                            
                            for($i=0;$i<count($bksub_list);$i++)
                            {
								$bksubdata =$this->Marks_model->fetch_bklogsub_details($bksub_list[$i]['sub_id'],$bksub_list[$i]['stream_id'],$bksub_list[$i]['semester']);
								foreach($bksubdata as $bprn){
								   $bstr_prn .= $bprn['enrollment_no'].', ';
							   }
                            ?>							 						
                            <tr>
							
                              <td><?=$j?></td>
                                 <td><?=strtoupper($bksub_list[$i]['subject_code'])?></td> 
                                 <td><?php echo strtoupper($bksub_list[$i]['subject_name']);?></td> 
								
								<td>A</td>
								<td>1</td>
								<td></td>		
								<td><?=count($bksubdata);?></td>
								<td><?=rtrim($bstr_prn,', ');?></td>
								<td></td>								
                            </tr>
                            <?php
                            $j++;
                            }
						  }else{
							  echo "<tr><td colspan=9> No data found.</td></tr>";
						  }
                            ?>                            
                        </tbody>
                    </table>  
					<?php
                          }?>
						  