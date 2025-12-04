<table class="table table-bordered" >													
	<thead>
	<tr  style="background:#e9a23b !important">	
	<th>Topic No.</th>
		<th>Sub Topic No.</th>
		<th>Sub Topic Name</th>								
	</tr>
	</thead>
	<tbody id="studtbl">
	<?php
		$k=1;
		if(!empty($subtopic_details)){
			foreach($subtopic_details as $stpc){?>
			<tr > 
				<td><?=$stpc['topic_id']?></td>
				<td><?=$stpc['sub_topic_no']?></td>  
				<td><?=$stpc['sub_topic_name']?></td>  
		</tr>
		<?php 
		$k++;
			}
		}else{
			echo "<tr><td colspan=3>No sub topic recored found.</td></tr>";
		}?>
	</tbody>
</table>