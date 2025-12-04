<table cellpadding="0" cellspacing="0" border="0" align="center" width="100%" style="margin-bottom:5px;">
	<tr>
	<td width="80" align="right" style="text-align:right;padding-top:5px;"><img src="<?=base_url()?>assets/images/logo-7.jpg" alt="" width="70" border="0"></td>
	<td style="font-weight:normal;text-align:center;">
	<h1 style="font-size:30px;">Sandip University</h1>
	<p>Mahiravani, Trimbak Road, Nashik – 422 213</p>

	</td>
	<td width="120" align="right" valign="top" style="text-align:center;padding-top:15px;">
	<h3 style="font-size: 25px">COE</h3></td>

	<tr>
	<td></td>
	<td align="center" style="text-align:center;margin:0;padding:0"><h3 style="font-size:18px;">Programme List</h3></td>
	<td></td>
	</tr><br>
			
 </table>
<table  border="0" align="center" width="100%" cellpadding="5" cellspacing="5" style="font-size:12px;">
            <thead>
			<tr style="border:1px solid #000;">
			<th style="border-top:1px solid #000" align="center">Sr.No</th>
			<th style="border:1px solid #000" align="left">Programme Name</th>
			<th style="border:1px solid #000" align="left">Specialization</th>
			<th  style="border:1px solid #000" align="center">Start Year</th>	
			<th  style="border:1px solid #000" align="center">Pattern</th>	
            <th  style="border:1px solid #000" align="center">Duration</th>		
            
            </tr>
			</thead>
			<tbody>
             <?php
			$k=1;
			$CI =& get_instance();
			$CI->load->model('Master_model');
			foreach($school_details as $sch){
				
					$stream_details =$this->Master_model->get_schoolwise_stream_details($sch['school_id']);
					?>
					<tr style="border:1px solid #000;">
						<td style="border:1px solid #000;" colspan=6 align="left"><b><?=$sch['school_name']?></b></td>		
					</tr>
			<?php 
				if(!empty($stream_details)){
					foreach($stream_details as $stud){
			?>
			<tr style="border:1px solid #000;">
				<td style="border:1px solid #000;" width="5%" align="center"><?=$k?></td>
				<td style="border:1px solid #000;"><?=$stud['gradesheet_name']?></td>
				<td style="border:1px solid #000;" align="left"><?=$stud['specialization']?></td>				
			   <td style="border:1px solid #000;" align="center"><?=$stud['start_year']?></td>
			   <td style="border:1px solid #000;" align="center"><?=$stud['course_pattern']?></td>
			   <td style="border:1px solid #000;" align="center"><?=$stud['course_duration']?></td>
            </tr>
			<?php 
			$k++;

				}
				}
			}
			?>
			</tbody>

</table>

         