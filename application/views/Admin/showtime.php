<?php
//print_r($shift_time);
if(!empty($shift_time)){
echo"<label class='col-md-3 control-label'>In Time</label>
        										<div class='col-md-3'>
        										<input type='text' class='form-control' name='intime' id='intime' placeholder='HH:MM:SS' value='".$shift_time[0]['shift_start_time']."' >
        										</div>
												<label class=col-md-3 control-label'>Out Time</label>
        										<div class='col-md-3'>
        											<input type='text' class='form-control' name='outtime' id='outtime' placeholder='HH:MM:SS' value='".$shift_time[0]['shift_end_time']."' >
        										</div>";
												}
												else{}
?>

