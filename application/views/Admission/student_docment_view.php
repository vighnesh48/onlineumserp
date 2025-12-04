
    <script>
$(document).ready(function() {
    $('#example').DataTable( {
        dom: 'Bfrtip',
        targets: 'no-sort',
bSort: false,
     bPaginate: false,
        buttons: [
            
            {
                extend: 'excelHtml5',
                title: 'Student documents list'
            },
            
        ]
    } );

       
} );
</script>
<table class="table table-bordered" id="example">
                        <thead>
                            <tr>
                                   
                                    <th>S.No.</th>
                                    <th>PRN</th>
                                    <th>Name</th>
                                    <th>Stream </th>
									                   <th>Year</th>
									                   <th>Gender </th>
                                      <th>DOB</th>
                                    <th>Mobile</th>
                                    <th>SSC</th>
                                    <th>HSC</th>
                                    <th>Graduation</th>
                                    <th>ITI</th>
                                    <th>Post Graduation</th>
                                    <th>Diploma</th>
                                     <th>Application form</th>
                                    <th>Leaving Certificate</th>
									                   <th>DOB Proof</th>	
                                    <th>Domicile Certificate </th>
                                    <th>ID Proof </th>
                                    <th>Migration/Transfer certificate </th>
                                    <th>Cast/Category certificate </th>
                                    <th>Caste Validity Certificate</th>
                                    <th>Profile Image</th>
                                    <th>Student Signature</th>
                                    <th>Experience Certificate </th>
                                    <th>Industry Sponsor Letter </th>
                                    

									
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php
                            
                          
                            $j=1; 
                                                  
                            for($i=0;$i<count($emp_list);$i++)
                            {

                                $docid=array();
                               
                                if($emp_list[$i]['docdata']!='')
                                {
                                   $docid=explode(",", $emp_list[$i]['docdata']);
                                   if(in_array('1', $docid))
                                   {
                                        $applicationform='Uploaded';

                                   }
                                   else
                                   {
                                        $applicationform='Not Uploaded';

                                   }

                                   if(in_array('2', $docid))
                                   {
                                         $LeavingCertificate='Uploaded';

                                   }
                                   else
                                   {
                                         $LeavingCertificate='Not Uploaded';

                                   }
                                   if(in_array('3', $docid))
                                   {
                                        $DOBProof='Uploaded';

                                   }
                                   else
                                   {
                                        $DOBProof='Not Uploaded';

                                   }
                                   if(in_array('4', $docid))
                                   {
                                        $DomicileCertificate='Uploaded';

                                   }
                                   else
                                   {
                                        $DomicileCertificate='Not Uploaded';

                                   }
                                    if(in_array('5', $docid))
                                   {
                                        $IDProof='Uploaded';

                                   }
                                   else
                                   {
                                        $IDProof='Not Uploaded';

                                   }
                                   if(in_array('6', $docid))
                                   {
                                         $MigrationTransfercertificate='Uploaded';

                                   }
                                   else
                                   {
                                         $MigrationTransfercertificate='Not Uploaded';

                                   }
                                   if(in_array('7', $docid))
                                   {
                                        $CastCategorycertificate='Uploaded';

                                   }
                                   else
                                   {
                                        $CastCategorycertificate='Not Uploaded';

                                   }
                                   if(in_array('8', $docid))
                                   {
                                        $CasteValidityCertificate='Uploaded';

                                   }
                                   else
                                   {
                                        $CasteValidityCertificate='Not Uploaded';

                                   }
                                   if(in_array('9', $docid))
                                   {
                                        $ProfileImage='Uploaded';

                                   }
                                   else
                                   {
                                        $ProfileImage='Not Uploaded';

                                   }
                                   if(in_array('10', $docid))
                                   {
                                        $StudentSignature='Uploaded';

                                   }
                                   else
                                   {
                                        $StudentSignature='Not Uploaded';

                                   }
                                   if(in_array('11', $docid))
                                   {
                                        $ExperienceCertificate='Uploaded';

                                   }
                                   else
                                   {
                                        $ExperienceCertificate='Not Uploaded';

                                   }
                                   if(in_array('12', $docid))
                                   {
                                        $IndustrySponsorLetter='Uploaded';

                                   }
                                   else
                                   {
                                        $IndustrySponsorLetter='Not Uploaded';

                                   }
                                   

                                }
                                else
                                {
                                    $applicationform='Not Uploaded';
                                    $LeavingCertificate='Not Uploaded';
                                    $DOBProof='Not Uploaded';
                                    $DomicileCertificate='Not Uploaded';
                                    $IDProof='Not Uploaded';
                                    $MigrationTransfercertificate='Not Uploaded';
                                    $CastCategorycertificate='Not Uploaded';
                                    $CasteValidityCertificate='Not Uploaded';
                                    $ProfileImage='Not Uploaded';
                                    $StudentSignature='Not Uploaded';
                                    $ExperienceCertificate='Not Uploaded';
                                    $IndustrySponsorLetter='Not Uploaded';
                                }
                                // check qualification documents
                                if($emp_list[$i]['docdata']!='')
                                {
                                   $degree_type=explode(",", $emp_list[$i]['degree_type']);
                                   if(in_array('SSC', $degree_type))
                                   {
                                        $SSC='Uploaded';

                                   }
                                   else
                                   {
                                        $SSC='Not Uploaded';

                                   }

                                   if(in_array('HSC', $degree_type))
                                   {
                                         $HSC='Uploaded';

                                   }
                                   else
                                   {
                                         $HSC='Not Uploaded';

                                   }
                                   if(in_array('Graduation', $degree_type))
                                   {
                                        $Graduation='Uploaded';

                                   }
                                   else
                                   {
                                        $Graduation='Not Uploaded';

                                   }
                                   if(in_array('ITI', $degree_type))
                                   {
                                        $ITI='Uploaded';

                                   }
                                   else
                                   {
                                        $ITI='Not Uploaded';

                                   }
                                    if(in_array('PostGraduation', $degree_type))
                                   {
                                        $PostGraduation='Uploaded';

                                   }
                                   else
                                   {
                                        $PostGraduation='Not Uploaded';

                                   }
                                   if(in_array('Diploma', $degree_type))
                                   {
                                         $Diploma='Uploaded';

                                   }
                                   else
                                   {
                                         $Diploma='Not Uploaded';

                                   }
                                   

                                }
                                else
                                {
                                    $SSC='Not Uploaded';
                                    $HSC='Not Uploaded';
                                    $Graduation='Not Uploaded';
                                    $ITI='Not Uploaded';
                                    $PostGraduation='Not Uploaded';
                                    $Diploma='Not Uploaded';
                                   
                                }


                                
                            ?>
							
							<tr>
                                <td><?=$j?></td>
								 <td><?=$emp_list[$i]['enrollment_no']?></td>
                                 <td><?=$emp_list[$i]['first_name']?></td> 
								<td><?=$emp_list[$i]['stream_name']?></td> 
								<td><?=$emp_list[$i]['current_year']?></td> 
								<td>
								<?php
									if(!empty($emp_list[$i]['gender']) && $emp_list[$i]['gender']=='M'){
										echo "Male";
									}else{
										echo "Female";
									}
								?>
								</td>								
								<td><?=$emp_list[$i]['dob']?></td>                                                    
                                <td><?=$emp_list[$i]['mobile'];?></td>
                                <td><?=$SSC;?></td>
                                <td><?=$HSC;?></td>
                                <td><?=$Graduation;?></td>
                                <td><?=$ITI;?></td>
                                <td><?=$PostGraduation;?></td>
                                <td><?=$Diploma;?></td>
                                <td><?=$applicationform?></td> 
                                <td><?=$LeavingCertificate?></td>
                                 <td><?=$DOBProof?></td>  
                                 <td><?=$DomicileCertificate?></td>
                                 <td><?=$IDProof?></td> 
                                 <td><?=$MigrationTransfercertificate?></td> 
                                 <td><?=$CastCategorycertificate?></td> 
                                 <td><?=$CasteValidityCertificate?></td> 
                                 <td><?=$ProfileImage?></td> 
                                 <td><?=$StudentSignature?></td> 
                                 <td><?=$ExperienceCertificate?></td> 
                                 <td><?=$IndustrySponsorLetter?></td>                      
                                                        
                             
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table> 
