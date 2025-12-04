<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.flash.min.js" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
<script src="https://code.jquery.com/jquery-3.7.0.js" type="text/javascript"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js" type="text/javascript"></script>

<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css" rel="stylesheet">
<link href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css" rel="stylesheet">

<style>
table, th, td {
  border: 1px solid black;
}
</style>
<?php
$total=count($student_data);
$total+=2;


	  $rowlb=2;


					
					echo 'STUDENTS GRADE SHEET'
					
					?>
					<table id="example" class="table table-striped table-bordered" style="width:100%">
						<thead>
						<tr>
							<td>ORG_NAME</td>
							<td>ORG_NAME_L</td>
							<td>ACADEMIC_COURSE_ID</td>
							<td>COURSE_NAME</td>
							<td>COURSE_NAME_L</td>
							<td>STREAM</td>
							<td>STREAM_L</td>
							<td>SESSION</td>
							<td>REGN_NO</td>
							<td>RROLL</td>
							<td>CNAME</td>
							<td>GENDER</td>
							<td>DOB</td>
							<td>FNAME</td>
							<td>MNAME</td>
							<td>PHOTO</td>
							<td>MRKS_REC_STATUS</td>
							<td>RESULT</td>
							<td>YEAR</td>
							<td>MONTH</td>
							<td>DIVISION</td>
							<td>GRADE</td>
							<td>PERCENT</td>
							<td>SEM</td>
							<td>EXAM_TYPE</td>
							<td>TOT</td>
							<td>TOT_MRKS</td>
							<td>TOT_CREDIT</td>
							<td>TOT_CREDIT_POINTS</td>
							<td>GRAND_TOT_MAX</td>
							<td>GRAND_TOT_CREDIT_POINTS</td>
							<td>CGPA</td>
							<td>SGPA</td>
							<td>ABC_ACCOUNT_ID</td>
							<td>TERM_TYPE</td>
							<?php for($i=1;$i<=12;$i++)
			  {
                 $j=$rowlb;			
			echo '<td>SUB'.$i.'NM</td>';
			echo '<td>SUB'.$i.'_TH_MAX</td>';
			echo '<td>SUB'.$i.'_PR_MAX</td>';
			echo '<td>SUB'.$i.'_CE_MAX</td>';
			echo '<td>SUB'.$i.'_TH_MRKS</td>';
			echo '<td>SUB'.$i.'_PR_MRKS</td>';
			echo '<td>SUB'.$i.'_CE_MRKS</td>';
			echo '<td>SUB'.$i.'_TOT</td>';
			echo '<td>SUB'.$i.'_GRADE</td>';
			echo '<td>SUB'.$i.'_GRADE_POINTS</td>';
			echo '<td>SUB'.$i.'_CREDIT</td>';
			echo '<td>SUB'.$i.'_CREDIT_POINTS</td>';
			echo '<td>SUB'.$i.'_REMARKS</td>';
			  } ?>
						</tr>
						</thead>
						<tbody>
		<?

           	foreach($student_data as $row) {
				
		   $subject_data=$this->Admin_model->fetch_subject_data($row['RROLL']);
	       $count=count($subject_data);
		   
		   	$rowlb++;
			echo '<tr>';
			echo '<td>'.$row['ORG_NAME'].'</td>';
			echo '<td>'.$row['ORG_NAME_L'].'</td>';
			echo '<td>'.$row['ACADEMIC_COURSE_ID'].'</td>';
			echo '<td>'.$row['course_name'].'</td>';
			echo '<td>'.$row['COURSE_NAME_L'].'</td>';
			echo '<td>'.$row['stream_name'].'</td>';
			echo '<td>'.$row['STREAM_L'].'</td>';
			echo '<td>'.$row['SESSION'].'</td>';
			echo '<td>'.$row['REGN_NO'].'</td>';
			echo '<td>'.$row['RROLL'].'</td>';
			echo '<td>'.$row['CNAME'].'</td>';
			echo '<td>'.$row['gender'].'</td>';
			echo '<td>'.$row['dob'].'</td>';
			echo '<td>'.$row['FNAME'].'</td>';
			echo '<td>'.$row['MNAME'].'</td>';
			echo '<td>'.$row['PHOTO'].'</td>';
			echo '<td>'.$row['MRKS_REC_STATUS'].'</td>';
			echo '<td>'.$row['RESULT'].'</td>';
			echo '<td>'.$row['YEAR'].'</td>';
			echo '<td>'.$row['MONTH'].'</td>';
			echo '<td>'.$row['division'].'</td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td></td>';
			echo '<td></td>';

  
			
			 $add='AJ';
			for($i=0;$i<$count;$i++)
			  {
                $j=$rowlb;	
				echo '<td>'.$subject_data[$i]['subject_name'].'</td>';
				echo '<td>'.$subject_data[$i]['subject_code'].'</td>';
				echo '<td>'.$subject_data[$i]['theory_max'].'</td>';
				echo '<td>'.$subject_data[$i]['practical_max'].'</td>';
				echo '<td>'.$subject_data[$i]['sub_max'].'</td>';
				echo '<td>'.$subject_data[$i]['optd_th_marks'].'</td>';
				echo '<td>'.$subject_data[$i]['optd_pr_marks'].'</td>';
				echo '<td>'.$subject_data[$i]['optd_cia_marks'].'</td>';
				echo '<td>'.$subject_data[$i]['final_garde_marks'].'</td>';
				echo '<td>'.$subject_data[$i]['final_grade'].'</td>';
				echo '<td>'.$subject_data[$i]['grade_point'].'</td>';
				echo '<td>'.$subject_data[$i]['subj_credits'].'</td>';
				echo '<td>'.$subject_data[$i]['subgradepoints'].'</td>';
				echo '<td>'.$subject_data[$i]['subject_name'].'</td>';
		
			  }
			echo '</tr>';
			}	
?>
<tbody>
<script>
 $(document).ready(function (){
		$('#example').DataTable({
						orderCellsTop: true,
                        fixedHeader: true,
						dom: 'lBfrtip',
					    destroy: true,
						retrieve:true,
						paging:true,
						buttons: [
							 'excel'
						],
						lengthMenu: [[10, 25, 50, -1], [10, 25, 50, "All"]],					  
					  });
	           }); 	 
</script>