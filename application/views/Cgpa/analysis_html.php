
                                   <?php
                                   switch($rpt['report_type']){
                                       case "1":
                                      
                                   
                                   ?>
                                    <table class="table table-bordered">
            						<thead>
            							<tr>
            								<th width="5%">#</th>
            								<th width="15%">Stream</th>
            								<th width="5%">Sem</th>
            								<th width="2%">#Appeared</th>
            								<th>P1</th>
            								<th>P2</th>
            								<th>P3</th>
            								<th>P4</th>
            								<th>P5</th>
            								<th>P6</th>
            								<th>P7</th>
            								<th>P8</th>
            								<th>P9</th>
            								<th>P10</th>
            								<th>#With held</th>
            								<th>#All Clear</th>
            								<th>Passing(%)</th>
            							</tr>
            						</thead>
            						<tbody class="valign-middle">
                                    <?php
                                    $i=1;
                                    
                                    foreach($result as $row){
                                    
                                    echo' <tr data-toggle="collapse" data-target=".order'.$i.'">
                                        <td>'.$i.' </td>
                                         <td>'.$row['stream_short_name'].'</td>
                                         <td>'.$row['semester'].'</td>
                                         <td><b>'.$row['appeared'].'</b></td>
                                         <td>'.$row['sub1'].'</td>
                                         <td>'.$row['sub2'].'</td>
                                          <td>'.$row['sub3'].'</td>
                                           <td>'.$row['sub4'].'</td>
                                            <td>'.$row['sub5'].'</td>
                                             <td>'.$row['sub6'].'</td>
                                              <td>'.$row['sub7'].'</td>
                                               <td>'.$row['sub8'].'</td>
                                                <td>'.$row['sub9'].'</td>
                                                 <td>'.$row['sub10'].'</td>
                                                  <td>'.$row['with_heald'].'</td>
                                                   <td><b>'.$row['all_clear'].'</b></td>
                                                    <td><b>'.sprintf('%.2f',round((((int)$row['all_clear']/(int)$row['appeared'])*100),2)).'</b></td></tr>';
                                         
                                        $i++;
                                    }
                                    if($i==1){
                                        echo'<tr><td colspan="15">Records not found.. </td></tr>';
                                    }
                                    ?>
                                   </tbody>
                                   </table>
                                   <?php
                                   break;
                                    case "2":
                                  
                                       
                                       ?>
                                         <table class="table table-bordered">
            						<thead>
            							<tr>
            								<th width="5%">#</th>
            								<th width="20%">Stream</th>
            								<th width="5%">Sem</th>
            								<th width="5%">Code</th>
            								<th width="20%">Name</th>
            								<th >#Appeared</th>
            								<th>#Fail</th>
            								<th>#With held</th>
            								<th>#All Clear</th>
            								<th>Passing(%)</th>
            							</tr>
            						</thead>
            						<tbody class="valign-middle">
                                    <?php
                                    $i=1;
                                    
                                    foreach($result as $row){
                                    
                                    echo' <tr data-toggle="collapse" data-target=".order'.$i.'">
                                        <td>'.$i.' </td>
                                         <td>'.$row['stream_short_name'].'</td>
                                         <td>'.$row['semester'].'</td>
                                          <td>'.$row['subject_code'].'</td>
                                           <td>'.$row['subject_name'].'</td>
                                         <td><b>'.$row['sub_total'].'</b></td>
                                         <td><b>'.$row['fail'].'</b></td>
                                         <td>'.$row['withheald'].'</td>
                                        <td><b>'.$row['pass'].'</b></td>
                                      <td><b>'.sprintf('%.2f',round((((int)$row['pass']/(int)$row['sub_total'])*100),2)).'</b></td></tr>';
                                         
                                        $i++;
                                    }
                                    
                                    if($i==1){
                                        echo'<tr><td colspan="15">Records not found.. </td></tr>';
                                    }
                                    
                                    ?>
                                   </tbody>
                                   </table>
                                   <?php
                                   
                                   break;
                                   }
            
                                   ?>
                                  
                              <input type="submit" id="search_excel" class="btn btn-primary btn-labeled" value="Excel" > 
                           
                                  
                               