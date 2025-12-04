<style>.form-control {
    margin-bottom: 4px!important;
}	
</style>

<div id="content-wrapper">
    <ul class="breadcrumb breadcrumb-page">
        <div class="breadcrumb-label text-light-gray">You are here: </div>        
        <li class="active"><a href="#">Masters</a></li>
        <li class="active"><a href="#">Digital</a></li>
    </ul>
        <div class="row ">
		            <div class="col-sm-12">
                <div class="panel">
                <div class="panel-heading">
                        <span class="panel-title"> Students Details</span>
                        <div class="holder"></div>
                </div>
				 <div class="panel-body" style="overflow-x:scroll;height:700px;">
                   <div class="table-info" >
                     <table class="table table-bordered" id="example">
                        <thead id="bd_tb" width="100%">
                            <tr>
							   <th class='text-center'>#</th>
							   <th class='text-center'>Enrollment No</th>
								 <th class='text-center'>Student Name</th>	
								  <th class='text-center'>Father Name</th>	
								    <th class='text-center'>Gender</th>
								    <th class='text-center'>Religion</th>
								    <th class='text-center'>Category</th>
								    <th class='text-center'>School Short Name</th>
								    <th class='text-center'>Course Short Name</th>
								    <th class='text-center'>Stream</th>
								    <th class='text-center'>Course Type</th>
								    <th class='text-center'>Programme Code</th>
								    <th class='text-center'>Course Pattern</th>
								    
								    <!--th class='text-center'>current Semester</th-->
								    <th class='text-center'>Mobile</th>
								    <th class='text-center'>Email</th>
								    <th class='text-center'>State Name</th>
								    <th class='text-center'>Nationality</th>
								    <th class='text-center'>Country Name</th>
								    <th class='text-center'>Admission Session</th>	
									<?php if($this->uri->segment(4)==15){?>									
								    <th class='text-center'>Admission Cycle</th>
									<?php }?>									
								    <th class='text-center'>Admission Year</th>
								    <th class='text-center'>Lateral Entry</th>
									<th class='text-center'>Academic Year</th>
									<!--th class='text-center'>Current Academic Year</th-->
									<th class='text-center'>Course Duration</th>
									<th class='text-center'>Semester</th>
								    <th class='text-center'>Year</th>									
								    <!--th class='text-center'>Current Year</th-->
								    <th class='text-center'>Final Year Student</th>
								    <th class='text-center'>Admission Confirm</th>
									<th class='text-center'>Degree Completed</th>
								    <th class='text-center'>Cancelled Admission</th>
								    <th class='text-center'>Cumulative GPA</th>
								    <th class='text-center'>ADM Flag</th>
                                </tr>
                            </thead>
                         <tbody id="itemContainer">	
                         <?php
                              $j=1;	  
                             for($i=0;$i<count($stud_details);$i++){
								 if($stud_details[$i]['course_duration']==$stud_details[$i]['year']){
									 $Passout='Y';
								 }else{
									 $Passout='N';
								 }
                            ?>
                            <tr class='text-center'>
                                <td style="align:center"><?=$j?></td>      
                                <td style="align:center"><?=$stud_details[$i]['enrollment_no']?></td>
                                <td style="align:center"><?=$stud_details[$i]['student_name']?></td>
                                <td style="align:center"><?=$stud_details[$i]['father_fname']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['gender']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['religion']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['category']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['school_short_name']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['course_short_name']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['stream_name']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['course_type']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['programme_code']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['course_pattern']?></td>  
                                  
                                <!--td style="align:center"><?=$stud_details[$i]['semester']?></td-->  
                                <td style="align:center"><?=$stud_details[$i]['mobile']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['email']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['state_name']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['nationality']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['countryname']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['admission_session']?></td> 
								<?php if($this->uri->segment(4)==15){?>
                                <td style="align:center"><?=$stud_details[$i]['admission_cycle']?></td> 
								<?php }?>
                                <td style="align:center"><?=$stud_details[$i]['admission_year']?></td> 
                                <td style="align:center"><?=$stud_details[$i]['lateral_entry']?></td> 
								<td style="align:center"><?=$stud_details[$i]['academic_year']?></td>  
								<!--td style="align:center"><?=$stud_details[$i]['curr_academic_year']?></td-->  
								<td style="align:center"><?=$stud_details[$i]['course_duration']?></td>										
								<td style="align:center"><?=$stud_details[$i]['year']*2;?></td>										
                                <td style="align:center"><?=$stud_details[$i]['year']?></td> 
														
                                <!--td style="align:center"><?=$stud_details[$i]['current_year']?></td-->  
                                <td style="align:center"><?=$Passout?></td>  
                                <td style="align:center"><?=$stud_details[$i]['admission_confirm']?></td> 
								<?php if($this->uri->segment(4)==15){?>								
                                <td style="align:center"><?php if($stud_details[$i]['degree_completed_year']==$stud_details[$i]['academic_year']){ echo 'Y';}else{ echo '-';}?></td>  
								<?php }else{?>
								<td style="align:center"><?=$stud_details[$i]['degree_completed']?></td>  
								<?php }?>
                                <td style="align:center"><?=$stud_details[$i]['cancelled_admission']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['cumulative_gpa']?></td>  
                                <td style="align:center"><?=$stud_details[$i]['admission_flag']?></td>  
                            </tr>
							   
                            <?php
                            $j++;
							  }  ?>					
							</tbody>
                        </table>
					 </form>
                  </div>
               </div>				
            </div>    
       </div>
    </div>
 </div>
<script>
        $(document).ready(function(){
			var filename='<?=$this->uri->segment(3)?>';
			var type='<?=$this->uri->segment(6)?>';
			if(type==0){
				typ="All Active";
			}else if(type=='N'){
				typ="New Admission";
			}else if(type=='R'){
				typ="Re-registration";
			}else{
				typ="Cancellation";
			}
	     $('#example').DataTable({
								orderCellsTop: true,
								fixedHeader: true,
								dom: 'lBfrtip',
								destroy: true,
								retrieve:true,
								paging:false,
								info: false,
								
								buttons: [
            {
                extend: 'excelHtml5',
                title: filename+'-'+typ+'-Students data'
            }
          
        ],
		 					  });					                
                         });
</script>	   
	   
	   
	   