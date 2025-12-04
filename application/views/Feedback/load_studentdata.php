   <?php
   $role_id =$_SESSION['role_id'];
   //echo $urlseg = $this->uri->segment(3);
if(count($emp_list)>0)
{
	$fd =0;
    $j=1;                            
                            for($k=0;$k<count($emp_list);$k++)
                            {
                                if(!empty($emp_list[$k]['status'])){ 
									$submitted[] = $fd+1; 
								}
							}
   ?>
 <div class="row ">
            <div class="col-sm-2">Total: <b><?=count($emp_list)?></b></div><div class="col-sm-2"> Submitted: <b><?=array_sum($submitted);?></b></div><div class="col-sm-4">Not Submitted: <b><?=count($emp_list) - array_sum($submitted);?></b></div><div class="col-sm-3"><!--a href="<?=base_url()?>feedback/stud_fd_status_excel/<?=$dcourse?>/<?=$dstream?>/<?=$dyear?>/<?=$fbcycle?>"><button class="btn btn-primary" >Excel</button></a--><button class="btn btn-primary pull-right" onclick="exportTableToCSV('Export_excel.csv')">Export To Excel</button> </div><div class="col-sm-1"></div>
					
        </div>
 <table class="table table-bordered" id="table2excel" style="margin-top: 9px;">
                        <thead>
                            <tr>
                                   
                                    <th>S.No.</th>
                                    <th>PRN</th>
                                     <!--th>Old PRN</th>
                                     <th>Form No.</th-->
                                     <!--th class="noExl">Photo1</th-->
                                    <th>Name</th>
                                    <th>Stream </th>
                                    <th>Semester</th>
									<th>Division</th>
                                    <th>Mobile</th>
									<th>Att %</th>
									<th>Feedback Status</th>
                            </tr>
                        </thead>
                        <tbody id="itemContainer">
                            <?php

                            $j=1;                            
                            for($i=0;$i<count($emp_list);$i++)
                            {
                               
                            ?>
							 <?php if($emp_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
								  else $bg="";?>								
                            <tr <?=$bg?> <?=$emp_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
                                
                               <td><?=$j?></td>
                        
                                 <td>'<?=$emp_list[$i]['enrollment_no'];?></td> 
							<td>
							<?php
								echo $emp_list[$i]['first_name']." ".$emp_list[$i]['middle_name']." ".$emp_list[$i]['last_name'];
								?>
								</td> 
								<td><?=$emp_list[$i]['stream_name']?></td>  
								<td><?=$emp_list[$i]['current_semester']?></td>
								<td><?=$emp_list[$i]['division']?></td>  								
                                <td><?=$emp_list[$i]['mobile'];?></td> 
								<td><?=sprintf('%0.2f', $emp_list[$i]['att_percentage']);?></td> 								
								<td ><?php if(!empty($emp_list[$i]['status'])){ echo "<span style='color:green;'>Submitted<span>";}else{ echo "<span style='color:red;'>Not Submitted</span>";}?></td> 								
                            </tr>
                            <?php
                            $j++;
                            }
                            ?>                            
                        </tbody>
                    </table>     
                     <?php
					 
}
else
{echo "No Results Found";}
                     ?>  
					 
<script>
function downloadCSV(csv, filename) {
    var csvFile;
    var downloadLink;

    // CSV file
    csvFile = new Blob([csv], {type: "text/csv"});

    // Download link
    downloadLink = document.createElement("a");

    // File name
    downloadLink.download = filename;

    // Create a link to the file
    downloadLink.href = window.URL.createObjectURL(csvFile);

    // Hide download link
    downloadLink.style.display = "none";

    // Add the link to DOM
    document.body.appendChild(downloadLink);

    // Click download link
    downloadLink.click();
}

function exportTableToCSV(filename) {
    var csv = [];
    var rows = document.querySelectorAll("table tr");
    
        for (var i = 0; i < rows.length; i++) {
        var row = [], cols = rows[i].querySelectorAll("td, th");
        
        for (var j = 0; j < cols.length; j++) 
            row.push(cols[j].innerText);
        
        csv.push(row.join(","));        
    }
	//var filef='';var files='';var filefb='';
//filef=$("#fbsession option:selected").html();
files=$("#select_School option:selected").html();
//filefb=$("#fbschool option:selected").html();
    // Download CSV file
    downloadCSV(csv.join("\r\n"), filename);
}

</script>					 
	    