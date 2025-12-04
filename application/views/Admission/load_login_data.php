
<?php

//var_dump($slist);
$i=0;
foreach($slist as $mlist)
{
    $i++;
    $st=$pt='';
    ?>
     <tr>
                                    <th rowspan="2" width="5%"><?=$i?></th>
                                    <th rowspan="2" width="5%"><input type='checkbox' name='selectall'></th>
                                    <th rowspan="2" width="10%"><?=$mlist['enrollment_no']?></th>
                                    <th rowspan="2" width="30%"><?=$mlist['first_name'].' '.$mlist['middle_name'].' '.$mlist['last_name']?></th>
                                    <th rowspan="2" width="5%"><?=$mlist['admission_year']?></th>
                                    
                            </tr>
                             <tr>
                                    <th><?php if($mlist['sstatus']=="Y" || $mlist['sstatus']=="N"){echo "Created"; $st="C";}else{echo "Not Created";$st="N"; }  ?></th>
                                    <th><?php 
                                    if($st=="C")
                                    {
                                        ?>
                                        <a href="javascript:void(0);" onclick="change_status('<?php echo $mlist['suid'] ?>','<?php echo $mlist['sstatus'] ?>','S','<?php echo $mlist['stud_id'] ?>')"><span id="stest">
                                        <?php
                                    if($mlist['sstatus']=="Y"){echo "Active";} else {echo "Not Active";}
                                ?></span>
                                </a>
                                <?php
                                     } 
                                     else
                                     {
                                         ?><span id="csid">
 <a href="javascript:void(0);" onclick="create_login('<?php echo $mlist['enrollment_no'] ?>','S')">
                                        
                                         <?php
                                              echo "Create Student Login";
                                     }
                                    ?></a></span></th><th>Action</th>
                                    <th><?php if($mlist['pstatus']=="Y" || $mlist['pstatus']=="N"){echo "Created";$pt="C";}else{echo "Not Created";$pt="N";}  ?></th>

                                    <th><?php 
                                    if($pt=="C")
                                    {
                                    ?>
                                        <a href="javascript:void(0);" onclick="change_status('<?php echo $mlist['puid'] ?>','<?php echo $mlist['pstatus'] ?>','P','<?php echo $mlist['stud_id'] ?>')"><span id="ptest">
                                        <?php
                                    if($mlist['pstatus']=="Y"){echo "Active";} else {echo "Not Active";}
                                   ?></span>
                                </a>
                                <?php
                                     } 
                                     else
                                     {
                                         ?><span id="cpid">
 <a href="javascript:void(0);" onclick="create_login('<?php echo $mlist['enrollment_no'] ?>','P')">
                                        
                                         <?php
                                              echo "Create Parent Login";
                                     }
                                    ?></a></span></th>
                                    <th> Action</th>
                            </tr>
    
    <?php
}
?>
<tr><td colspan=""><input type="button" name="student_id" id="student_id" value="Generate Student ID"></td>
<td colspan="10"><input type="button" name="generate_id" id="generate_id" value="Generate Parent ID"></td>
</tr>