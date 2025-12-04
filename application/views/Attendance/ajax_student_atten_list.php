  <table id="dis_data" class="table table-bordered">
                        <thead>
                            <tr>
                                      <th>SrNo.</th>
                                       <th> Academic Year</th>    
                                      <th> Academic Session</th> 
<th>PRN</th> 									  
                                      <th> NAME</th>
									  <th> Mobile</th> 
                                       <th> Stream</th>   
                                      <th> SEM</th> 
                                      <th> DIV </th>                                     
                                          <!--th> NO. Lecture Taken </th> 
                                      <th> Total Present</th> 
     <th> Total Absent</th--> 
     <th> Percentage</th> <th></th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer1">
 <?php
                            
                            //echo"<pre>";print_r($stud_list);echo"</pre>";exit();
                            if(!empty($stud_list)){
                                $j=1;                             
                          
                            //$cnt=count($stud_list);                          
                            
                            // echo $stud_list[2]['called_by'];
                          foreach($stud_list as $value){                            
                           
                           $larr['divs']=$value['division'];
                           $larr['acd_year']=$value['academic_year'];
$larr['strm_id']=$value['stream_id'];
$larr['sem']=$value['semester'];
$larr['fdate']=$sfdate;
$larr['tdate']=$stdate;
$ayexp = explode('~',$acd_yer);
$larr['acd_sess'] = substr($ayexp[1],0,3);
//$tot_lec=$this->Student_Attendance_model->get_total_lecture($larr);
//print_r($tot_lec);
$larr['stdid']=$value['student_id'];
//$std['fdate']=$sfdate;
//$std['tdate']=$stdate;
//$larr['acd_year']=$value['academic_year'];

//$pacnt = $this->Student_Attendance_model->get_student_total_attendance_count($larr);
if($value['percen_lecturs']<'60'){
  $s = 'style="background-color:#fc8e8e;"';
}else{
  $s='';
}
                          ?>
                            <tr <?php echo $s; ?> >
                            
                                <td><?=$j?></td>
                                <td><?=$value['academic_year']?></td> <td><?php 
                                if(substr($ayexp[1],0,3)=='WIN'){ echo 'WINTER'; }elseif(substr($ayexp[1],0,3)=='SUM'){
echo 'SUMMER';
} ?></td>
								<td><?=$value['enrollment_no']?></td>
                                  <td><?=$value['first_name']." ".$value['last_name']?></td> 
									<td><?=$value['mobile']?></td>								  
                                <td><?=$value['stream_short_name']?></td>
                                <td><?=$value['semester']?></td>
                                <td><?=$value['division']?></td>
                           
                          <!--td><?=($value['tpresent']+$value['tapsent'])?></td>
<td><?=$value['tpresent']?></td>
<td><?=$value['tapsent']?></td-->
                         
<!-- <td><?php
//$tp = $pacnt[0]['present_tot']+$pacnt[0]['apsent_tot'];
//echo $cnt = round(($pacnt[0]['present_tot']/$tp)*100,2)."%";

 ?></td> -->
 <td><?=$value['percen_lecturs']?></td>
 <?php $s=$value['academic_year']."~".substr($ayexp[1],0,3)."~".$value['enrollment_no']."~".$value['semester']."~".$value['division']."~".$sfdate."~".$stdate;
echo "<td><a href='".base_url()."Student_attendance/get_student_list_apsent_details/".$s."' target='_blank'>View</a></td>";
?>
                            </tr>
                        
                            
                           <?php                             
                            
                        $j++;
                          }
                          }
               
                            ?>    
                            </tbody>
                            </table>              
                           
<script>
$(document).ready(function() {
   $('#dis_data').DataTable( {
        dom: 'Bfrtip',
         targets: 'no-sort',
bSort: false,
     "bPaginate": false,
        buttons: [
            {
                extend: 'excelHtml5',
                title: 'Student Attendance Report',
                exportOptions: {          
                columns: [0,1,2,3,4,5,6,7,8,9,10]
            }
            },
            {
                extend: 'pdfHtml5',
                title: 'Student Attendance Report',
                exportOptions: {          
                columns: [0,1,2,3,4,5,6,7,8,9,10]
            }
            }
        ]
    } );

       
} );
</script>