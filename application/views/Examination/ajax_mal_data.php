		<form id="form" name="form" action="<?=base_url($currentModule.'/genrate_malpractice_forstudents')?>" method="POST"> 
		 <div class="panel-body">
                        <div class="table-info">   
		<table class="table table-bordered" id="table2excel" style="margin-left: 10px;">
	<thead>
		<tr>
             <th><input type="checkbox" name="chk_stud_all" id="chk_stud_all"></th>                      
			<th>S.No.</th>
			<th>PRN</th>
			<th>Name</th>
			<th>Stream</th>
			
			<th>Semester</th>
			<th>Notice letter</th>	
		</tr>
	</thead>
	<tbody id="itemContainer">
		<?php
		$j=1;
		if(!empty($malpractice_list)){
			for($i=0;$i<count($malpractice_list);$i++){
				$studid=$malpractice_list[$i]['stud_id'];

				if ($malpractice_list[$i]["mal_practice_token"]!=''){
					$applied = "style='background-color:#bfd4ac;'";
					//$aurl = base_url()."subject_allocation/view_studSubject/".$stud['stud_id'];
					$ahref= "<a  href='#' title='View' onClick='showDiv($studid)'><i class='fa fa-file-pdf-o' aria-hidden='true'  style='font-size:20px;color:red;''></i></a>";
					$disabled="disabled";
				}else{
					$applied = "";
					$ahref ="";
					$disabled="";
				}
                                
				?>
				<?php if($malpractice_list[$i]['ro_flag']=='on') $bg="bgcolor='#e6eaf2'";
				else $bg="";?>								
				<tr <?=$bg?> <?=$malpractice_list[$i]["cancelled_admission"]=="Y"?"style='background-color:#f5b9a1'":""?>>
                      <td><input type="checkbox" name="chk_stud[]" id="chk_stud" class='studCheckBox' value="<?=$malpractice_list[$i]['stud_id']?>" <?=$disabled?>></td>          
					<td><?=$j?></td>
                        
					<td><?=$malpractice_list[$i]['enrollment_no']?></td> 
 
					<td>	
						<?php
						echo $malpractice_list[$i]['first_name']." ".$malpractice_list[$i]['last_name'];
						?>
					</td> 
                  
				<td><?=$malpractice_list[$i]['stream_short_name'];?></td>  
				
					<td><?=$malpractice_list[$i]['current_semester'];?></td>  
					  	
				
			<!-- 	<td><input type="text" name="block" id="block" placeholder="Enter Block" /></td> -->

					<td><?=$ahref ?></td>

							
							
				</tr>

				<?php
				$j++;
			}
		}else{ ?>
								
			<tr><td colspan='9' align='center'>No data found.</td></tr>
			<?php }
		?>                            
	</tbody>
	</table>

	<?php if(!empty($malpractice_list)){?>
		<div class="col-sm-3"><textarea name="blockaddress" id="blockaddress" class="form-control" placeholder="Venue/Time/Date" required="true"></textarea></div>  
							<div class="col-sm-2"> <button class="btn btn-primary " id="btn_submit" type="submit" onclick="return validate_student(this.value)">Genrate malpractice</button> </div>
							<?php }?> 
		<input type="hidden" name="exam_se" id="exam_se" value="<?php echo $exam_session;?>" />
		<input type="hidden" name="schoolid" id="schoolid" value="<?php echo $schoolid;?>"/>

						</form>
					</div></div>


<form action="<?php echo base_url()?>examination/malpractice_notice_letter" id="pdfdata" name="pdfdata" method="post">
	
	<input type="hidden" name="exam_sessionn" id="exam_sessionn" />
	<input type="hidden" name="studentid" id="studentid"/>
	<input type="hidden" name="schoolidd" id="schoolidd"/>
	
</form>
<script>
	$('#chk_stud_all').change(function () {
        $('.studCheckBox').prop('checked', $(this).prop('checked'));
    });
function showDiv(pageid)
{


		$("#exam_sessionn").val($("#exam_session").val());
		$("#schoolidd").val($("#school_code").val());
		$("#studentid").val(pageid);
		 $("#pdfdata").trigger("submit");
  
}


function validate_student(strm){

	var chk_stud_checked_length = $('input[class=studCheckBox]:checked').length;
	var chk_sub_checked_length = $('input[class=subCheckBox]:checked').length;
	if(chk_stud_checked_length == 0){
		 alert('please check atleast one Student from student list');
		 return false;
	}
	/*else if($("#blockaddress").val()!='')
	{
		alert('please enter block ');
		 return false;

	}*/
	else{
		return true;
	}
} 
	</script>