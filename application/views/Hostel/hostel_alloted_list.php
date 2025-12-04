
<?php
$len=count($flr_details);
if($len>0)
{
	$ftemp = $flr_details[0]['floor_no'];
	$rtemp = $flr_details[0]['room_no'];
	$host_id=$flr_details[0]['host_id'];
	$cnt_tot=0;$cnt_in=0;$cnt_home=0;$cnt_city=0;$cnt_gh=0;$cnt_free=0;$cnt_room=1;
	$alloc_status='';
	$popupcontent='<div id="popover-content-pop_'.$ftemp.'_'.$host_id.'_'.$rtemp.'_'.$flr_details[0]['academic_year'].'" class="hide popover-list test">';
/* <img src="assets/demo/avatars/2.jpg" width="40" height="40" class="img-circle"></div>
        <div class="col-sm-9"><strong>Ankur Saxena</strong> <br>
          <small>B.Tech.Mechanical FY<br>
          SIEM</small></div>
      </div>
    </li>
  </ul>
</div> */
?>
<div class="notification">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="" rowspan="4" bgcolor="#88898f" ><div class="Setrow1 seatR"><?php
		if($ftemp==0)echo 'Ground';else echo $ftemp;?></div></td>
		<td valign="top" align="center"  class="padd-left">
			  <div class="col-sm-1 rooms-div"> 
				<div  class="row room-n"> <a  data-trigger="hover"  data-toggle="popover" data-container="body" data-placement="right" type="button" data-html="true"  id="pop_<?=$ftemp.'_'.$host_id.'_'.$rtemp.'_'.$flr_details[0]['academic_year']?>">Room No <?=$rtemp?></a> 
				</div>
<?php
$enroll_num='';
	for($i=0;$i<$len;$i++)
	{
		$cnt_tot++;
		if($flr_details[$i]['enrollment_no']!=null)
			$enroll_num = str_replace('/', '_', $flr_details[$i]['enrollment_no']);
		else
			$enroll_num = $flr_details[$i]['enrollment_no'];
		
		if($flr_details[$i]['student_id']!=null)
		{
			$title=nl2br("student_id: ".$flr_details[$i]['student_id']."\nenrollment_no: ".$enroll_num."\nStatus: ".$flr_details[$i]['present_status']);
			if($flr_details[$i]['present_status']=='CITY')
			{
				$cnt_city++;
				$alloc_status='onclick="get_student_details('.$flr_details[$i]['f_alloc_id'].','.$flr_details[$i]['sf_room_id'].','.$flr_details[$i]['academic_year'].','.$flr_details[$i]['student_id'].','.$enroll_num.')" title="'.$title.'" class="yellow-bed" data-toggle="modal" data-target="#myModal"';
			}
			else if($flr_details[$i]['present_status']=='HOME')
			{
				$cnt_home++;
				$alloc_status='onclick="get_student_details('.$flr_details[$i]['f_alloc_id'].','.$flr_details[$i]['sf_room_id'].','.$flr_details[$i]['academic_year'].','.$flr_details[$i]['student_id'].','.$enroll_num.')" title="'.$title.'" class="red-bed" data-toggle="modal" data-target="#myModal"';
			}
			else if($flr_details[$i]['present_status']=='IN')
			{
				$cnt_in++;
				$enroll="'".$enroll_num."'";
				$alloc_status='onclick="get_student_details('.$flr_details[$i]['f_alloc_id'].','.$flr_details[$i]['sf_room_id'].','.$flr_details[$i]['academic_year'].','.$flr_details[$i]['student_id'].','.$enroll.')" title="'.$title.'" class="green-bed" data-toggle="modal" data-target="#myModal"';
			}
		}
		else
		{
			if($flr_details[$i]['category']=="Gym")
			{
				$alloc_status='title=" GYM " class="purple-bed" data-toggle="modal" data-target="#myModal"';
			}
			else if($flr_details[$i]['category']=="Guest House")
			{
				$cnt_gh++;
				$alloc_status='title=" Guest House " class="blue-bed" data-toggle="modal" data-target="#myModal"';
			}
			else if($flr_details[$i]['category']=="Parlour")
			{
				$alloc_status='title=" Parlour " class="pink-bed" data-toggle="modal" data-target="#myModal"';
			}
			else
			{
				$x=null;
				$cnt_free++;
				$alloc_status='onclick="get_student_details(null,'.$flr_details[$i]['sf_room_id'].',null,null,null)" title="Bed Available" class="grey-bed" data-toggle="modal" data-target="#myModal"';
			}
		}
		
		if($ftemp==$flr_details[$i]['floor_no'])
		{
			if($rtemp==$flr_details[$i]['room_no'])
			{
				$popupcontent.='';
?>
		<div class="seatI"><a <?=$alloc_status?>><?=$flr_details[$i]['bed_number']?></a></div>
	<?php
			}
			else
			{
				$cnt_room++;
				$popupcontent.='</div><div id="popover-content-pop_'.$flr_details[$i]['floor_no'].'_'.$host_id.'_'.$flr_details[$i]['room_no'].'_'.$flr_details[$i]['academic_year'].'" class="hide popover-list test">';
	?>
			</div>
			<div class="col-sm-1 rooms-div"> 
			<div  class="row room-n"> <a data-trigger="hover"  data-toggle="popover" data-container="body" data-placement="right" type="button" data-html="true"  id="pop_<?=$flr_details[$i]['floor_no'].'_'.$host_id.'_'.$flr_details[$i]['room_no'].'_'.$flr_details[$i]['academic_year']?>">Room No <?=$flr_details[$i]['room_no']?></a> 
			</div>
			<div  class="seatI"><a <?=$alloc_status?>><?=$flr_details[$i]['bed_number']?></a></div>
	<?php
			$rtemp = $flr_details[$i]['room_no'];	
			}
		}
		else
		{
			$cnt_room++;
			$popupcontent.='</div><div id="popover-content-pop_'.$flr_details[$i]['floor_no'].'_'.$host_id.'_'.$flr_details[$i]['room_no'].'_'.$flr_details[$i]['academic_year'].'" class="hide popover-list test">';
?>
			</div>
                      
		  </td>
	  </tr>
	</table>
	</div>
	<br>
	<div class="notification">
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
	  <tr>
		<td width="30" rowspan="4" bgcolor="#88898f"><div class="seatR Setrow1"><?=$flr_details[$i]['floor_no']?></div></td>
		<td valign="top" align="center" class="padd-left">
		<div class="col-sm-1 rooms-div">
			<div class="row room-n"><a data-trigger="hover"  data-toggle="popover" data-container="body" data-placement="right" type="button" data-html="true"  id="pop_<?=$flr_details[$i]['floor_no'].'_'.$host_id.'_'.$flr_details[$i]['room_no'].'_'.$flr_details[$i]['academic_year']?>">Room No <?=$flr_details[$i]['room_no']?></a></div>
			<div  class="seatI"><a <?=$alloc_status?>><?=$flr_details[$i]['bed_number']?></a></div>
<?php
		$ftemp = $flr_details[$i]['floor_no'];
		$rtemp = $flr_details[$i]['room_no'];
		}
	}
	
	$popupcontent.='</div>';
?>
			</div>
                      
		  </td>
	  </tr>
	</table>
	</div>
	<script>
	$('#cnt_in').html('<?=$cnt_in?>');
	$('#cnt_home').html('<?=$cnt_home?>');
	$('#cnt_city').html('<?=$cnt_city?>');
	$('#cnt_free').html('<?=$cnt_free?>');
	$('#cnt_gh').html('<?=$cnt_gh?>');
	$('#cnt_tot').html('<?=$cnt_tot?>');
	$('#cnt_room').html('<?=$cnt_room?>');
	
	</script>
	
	
	
	
	
<?php
	echo $popupcontent;
}
else
{
	echo "<span style=\"color:red;\">Hostel Not Found Please change search criteria and try again</span>";
}
?>
<!-- Pixel Admin's javascripts --> 
<script src="<?=base_url()?>assets/javascripts/pixel-admin.min.js"></script>
<script type="text/javascript">
$("[data-toggle=popover]").each(function(i, obj) {
$(this).popover({
  html: true,
  content: function() {
    var id = $(this).attr('id');
	var arr=id.split("_");
	$.ajax({
			type: 'POST',
			url: '<?= base_url() ?>Hostel/get_info',
			data: { host_id: arr[2], floors : arr[1],room:arr[3],academic_y:arr[4]},
			success: function (html) {
				var array=JSON.parse(html);
				len=array.get_info.length;
				info='<ul class="list-group">';
				var imurl='';
				for(i=0;i<len;i++)
				{
					if(array.get_info[i].organisation=='SU')
					{
						//imurl ='<img src="<?=base_url('uploads/student_photo')?>/'+array.get_info[i].enrollment_no+'.jpg"  width="40" height="40" class="img-circle">';

						var url = '<?= site_url() ?>Upload/getImageInfo/'+array.get_info[i].enrollment_no+'.jpg?b_name=<?=$bucketname ?>';
						$.ajax({url: url, dataType: 'json', async: false,
							success: function(response){ imageData = response.imageData;
						}});
						var imurl ='<img src="'+imageData+'" alt="" width="40" height="40">';
					}
					else
					{
					    imurl ='<img src="<?=base_url('assets/images')?>/nopic.jpg" width="40" height="40" class="img-circle">';
					}
					//alert(array.get_info[i].first_name);
					info+='<li class="list-group-item"><div class="row"><div class="col-sm-3">'+imurl+'</div><div class="col-sm-9"><strong>'+array.get_info[i].first_name+'</strong> <br><small>'+array.get_info[i].stream+' '+array.get_info[i].current_year+'<br>'+array.get_info[i].instute_name+'</small></div></div></li>';
				}
				info+='</ul>';
				$('#popover-content-' + id).html(info);
			}
	}); 
    return $('#popover-content-' + id).html();
  }
});

});</script>