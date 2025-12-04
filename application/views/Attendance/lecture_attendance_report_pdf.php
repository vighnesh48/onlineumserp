<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

</head>

<style>

.attexl table th{
    border: 1px solid black;
    padding: 5px;
    background-color:grey;
    color: white;
}
.add-table tr td{border:0px}

.attexl table  td{
     border: 1px solid black;
    padding: 5px;border-collapse: collapse
}
.bottom-table{padding:50px 0 20px 0}
.bottom-table-2{padding-top:20px}
</style>
<style>
         table {
         border-collapse: collapse;
         width: 100%;
         }
         td, th {        
         padding: 4px;
		 font-family:sans-serif;font-size:11px;font-weight:500;line-height:20px
         }
      </style>
<div class="row">

<div class="col-lg-12">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td valign="top" width="100"><img src="<?php echo base_url(); ?>assets/images/lg.png" alt="Sandip University" class="img-responsive"></td>
    <td valign="top" align="center">
    <span style="font-size:25px;text-align:center"><b>Sandip University</b></span><br>
    <span style="text-align:center;font-size:11px">Trimbak Road, A/p - Mahiravani, Nashik – 422 213</span><br>
    <span style="font-size:10px;text-align:center">Website : http://www.sandipuniversity.edu.in | Email : info@sandipuniversity.edu.in </span><br>
    <span style="font-size:15px;;text-align:center"><strong>Ph: (02594) 222 541 Fax: (02594) 222 555</strong></span>
    </td>
  </tr>
</table>
<hr  style="border-width:1px;">
<div align="center" style="text-align:center"><b>Lecture Attendance Report <?=date('d-m-Y');?></b></div>
</div>
<br	>
 <table class="table" style="width:100% !important; border: 1px solid black; border-collapse: collapse;">
    <thead>
        <tr>
            <th rowspan="2" style="border: 1px solid black;" width='5%'>#</th>
            <th rowspan="2" style="border: 1px solid black;" width='5%'>School</th>
            <th rowspan="2" style="border: 1px solid black;" width='35%'>Program Name</th>
            <th colspan="3" style="border: 1px solid black;" width='10%'>I Sem</th>
            <th colspan="3" style="border: 1px solid black;" width='10%'>III Sem</th>
            <th colspan="3" style="border: 1px solid black;" width='10%'>V Sem</th>
            <th colspan="3" style="border: 1px solid black;" width='10%' >VII Sem</th>
            <th colspan="3" style="border: 1px solid black;" width='10%' >IX Sem</th>
            <th rowspan="2" style="border: 1px solid black;" width='5%' >Avg</th>
        </tr>
        <tr>
            <th style="border: 1px solid black;">T</th>
            <th style="border: 1px solid black;">RR</th>
            <th style="border: 1px solid black;">P</th>
			<th style="border: 1px solid black;">T</th>
            <th style="border: 1px solid black;">RR</th>
            <th style="border: 1px solid black;">P</th>
			<th style="border: 1px solid black;">T</th>
            <th style="border: 1px solid black;">RR</th>
            <th style="border: 1px solid black;">P</th>
			<th style="border: 1px solid black;">T</th>
            <th style="border: 1px solid black;">RR</th>
            <th style="border: 1px solid black;">P</th>
			<th style="border: 1px solid black;">T</th>
            <th style="border: 1px solid black;">RR</th>
            <th style="border: 1px solid black;">P</th>
        </tr>
    </thead>
    <tbody id="itemContainer">
        <?php
        if (!empty($stud_data)) {
            $j = 1;$previous_school='';
            $organized_data = [];

            // Organize data by stream_name and semester
            foreach ($re_stud_data as $row) {
                $organized_data[$row['stream_name']][$row['school']][$row['semester']] = [
                    'stud_count' => $row['stud_count'],
                    'present_count' => $row['present_count'],
                    'present_percentage' => $row['present_percentage'],
					'rereg_stud_count' => $row['rereg_stud_count']
                ];
            }

            // Display organized data
            foreach ($organized_data as $stream_name => $schools) {
                   foreach ($schools as $school => $semesters) {
				$sem1_rereg = isset($semesters[1]) ? $semesters[1]['rereg_stud_count'] : '-';
                $sem1_total = isset($semesters[1]) ? $semesters[1]['stud_count'] : '-';
                $sem1_present = isset($semesters[1]) ? $semesters[1]['present_count'] : '-';
                
				$sem3_rereg = isset($semesters[3]) ? $semesters[3]['rereg_stud_count'] : '-';
                $sem3_total = isset($semesters[3]) ? $semesters[3]['stud_count'] : '-';
                $sem3_present = isset($semesters[3]) ? $semesters[3]['present_count'] : '-';
                
				$sem5_rereg = isset($semesters[5]) ? $semesters[5]['rereg_stud_count'] : '-';
                $sem5_total = isset($semesters[5]) ? $semesters[5]['stud_count'] : '-';
                $sem5_present = isset($semesters[5]) ? $semesters[5]['present_count'] : '-';
                
				$sem7_rereg = isset($semesters[7]) ? $semesters[7]['rereg_stud_count'] : '-';
                $sem7_total = isset($semesters[7]) ? $semesters[7]['stud_count'] : '-';
                $sem7_present = isset($semesters[7]) ? $semesters[7]['present_count'] : '-';
                
				$sem9_rereg = isset($semesters[9]) ? $semesters[9]['rereg_stud_count'] : '-';
                $sem9_total = isset($semesters[9]) ? $semesters[9]['stud_count'] : '-';
                $sem9_present = isset($semesters[9]) ? $semesters[9]['present_count'] : '-';

                // Calculate average percentage, only including existing semesters
                $total_percentage = 0;
                $count = 0;
                foreach ([$semesters[1]['present_percentage'] ?? 0, $semesters[3]['present_percentage'] ?? 0, $semesters[5]['present_percentage'] ?? 0, $semesters[7]['present_percentage'] ?? 0, $semesters[9]['present_percentage'] ?? 0] as $percentage) {
                    if ($percentage !== 0) {
                        $total_percentage += $percentage;
                        $count++;
                    }
                }
                $avg_percentage = ($count > 0) ? round($total_percentage / $count, 2) : '-'; ?>						
            <tr >
                <!--td style="border: 1px solid black;"><?=$j?></td> 
                <!--td style="border: 1px solid black;"><?=$school?></td--> 
				 <!--td style="border: 1px solid black;">
					<?php 
					/* if ($school !== $previous_school) {
						echo $school;
						$previous_school = $school;
					} */ 
					?>
				</td-->
				<?php 
					 if ($school !== $previous_school) {
					echo  '<td style="border-top: 1px solid black;">'.$j.'</td> ';
					echo  '<td style="border-left: 1px solid black;border-top: 1px solid black;">'.$school.'</td>'; 
						$previous_school = $school;$j++;
					}  else
					{
						echo '<td style="border-left: 1px solid black;"></td>';
						echo '<td style="border-left: 1px solid black;"></td>';
					}
					?>
                <td style="border: 1px solid black;"><?=$stream_name?></td>
                <td style="border: 1px solid black;"><?=$sem1_total?></td>
                <td style="border: 1px solid black;"><?=$sem1_total?></td> 
                <td style="border: 1px solid black;"><?=$sem1_present?></td> 
				<td style="border: 1px solid black;"><?=$sem3_rereg?></td>
                <td style="border: 1px solid black;"><?=$sem3_total?></td> 
                <td style="border: 1px solid black;"><?=$sem3_present?></td> 
				<td style="border: 1px solid black;"><?=$sem5_rereg?></td>
                <td style="border: 1px solid black;"><?=$sem5_total?></td> 
                <td style="border: 1px solid black;"><?=$sem5_present?></td> 
				<td style="border: 1px solid black;"><?=$sem7_rereg?></td>
                <td style="border: 1px solid black;"><?=$sem7_total?></td> 
                <td style="border: 1px solid black;"><?=$sem7_present?></td> 
				<td style="border: 1px solid black;"><?=$sem9_rereg?></td>
                <td style="border: 1px solid black;"><?=$sem9_total?></td> 
                <td style="border: 1px solid black;"><?=$sem9_present?></td> 
                <td style="border: 1px solid black;"><?=$avg_percentage?></td>  
            </tr>
				   <?php  }}}else{
            echo"<tr><td colspan='17' style='border: 1px solid black;'><label style='color:red'> No Record Found !!!!</label></td></tr>";
        }
        ?>                            
    </tbody>
</table>	


