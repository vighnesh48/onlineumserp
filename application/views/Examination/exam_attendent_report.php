<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>AttendSheet</title>
    <style>  
            table {  
                font-family: arial, sans-serif;  
                border-collapse: collapse;  
                width: 100%; font-size:12px; margin:0 auto;
            }  
			td{vertical-align: top;}
                      
            .signature{
            text-align: center;
            }
			p{padding:0px;margin:0px;}
            h1, h3{margin:0;padding:0}
			
			.content-table tr td{border:1px solid #333;vertical-align:middle;}
			.content-table th{border:1px solid #333;}
        </style>  

</head>




<body>



  <?php
  $this->load->library("m_pdf");
   $object = new mPDF();
  

  // $object->use_kwt = true;
//echo "<pre>";
//print_r($sublist);exit;
for($i=0;$i<count($sublist);$i++){
	$sublist[$i]['subject_code'];
	//echo $emp_list[$i]['emp_per'][0]['form_number'];
	$studlist = $sublist[$i]['studlist'];
	//print_r($studlist);
?>

					
<table class="content-table" width="800" cellpadding="0" cellspacing="0" border="1" align="center" style="font-size:12px;height:150px;overflow: hidden;margin:40px;">
            <tr>
            <td width="100" >&nbsp;<strong>Subject Code:</strong></td>
            <td >&nbsp;<?=$sublist[$i]['subject_name']?> - <?=$sublist[$i]['subject_code']?></td>
            <td width="80" height="30">&nbsp;<strong>Date:</strong> </td>
           <td >&nbsp;<?=date('d/m/Y', strtotime($sublist[$i]['date']));?></td>

            
            </tr>
           
            <tr>
            <td valign="middle">&nbsp;<strong>School Name:</strong></td>
            <td valign="middle">&nbsp;<?=$sublist[$i]['school_short_name']?></td>
            <td valign="middle">&nbsp;<strong>Time:</strong></td>
            <td valign="middle">&nbsp;<?php 
				$frmtime = explode(':', $sublist[$i]['from_time']);
				$totime = explode(':', $sublist[$i]['to_time']);
				echo $frmtime[0].':'.$frmtime[1].'-'.$totime[0].':'.$totime[1];
			?></td>
            </tr>
            <tr>
            <td width="100" height="30" valign="middle">&nbsp;<strong>Stream:</strong></td>
            <td  valign="middle">&nbsp;<?=$sublist[$i]['stream_name'];?></td>
            <td width="80" height="30" valign="middle">&nbsp;<strong>Semester</strong> </td>
           <td height="30" valign="middle">&nbsp;<?=$sublist[$i]['semester'];?></td>
           
            </tr>
             </table>			
  <table border="0" class="content-table" width="800"  style="height:800px;margin-top:0px;margin-right:40px;margin-bottom:40px;margin-left:40px;">
            <tr>
            <th width="50">Sr No.</th>
            <th>PRN</th>
            <th>Name</th>
            <th>Ans.Booklet No</th>
            <th>Candidate.Sign</th>
            </tr>
			<?php
$j=1;
				if(!empty($studlist)){
					foreach($studlist as $stud){
			//echo $stud['enrollment_no'];
			?>
            <tr>
            <td><?=$j?></td>
            <td><?=$stud['enrollment_no']?></td>
            <td><?=$stud['first_name']?> <?=$stud['middle_name']?> <?=$stud['last_name']?></td>
            <td></td>
            <td></td>
            </tr>
			<?php 
			$j++;
				}
				}else{
					//echo "<tr><td colspan=4>No data found.</td></tr>";
				}
			?>
       
            </table>
			
     
  
  <?php //exit;
 $object->AddPage(); 

}

//exit;?>

</body>
</html>
