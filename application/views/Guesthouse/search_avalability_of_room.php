 
					<div class="messages-list">	
			<div class="row text-center" id="itemContainer1" align="center" style="padding-left:30px;">
			
				
                 <?php 
				if(!empty($get_beds_available_gh))
				{
					$j=1;                      
					for($i=0;$i<count($get_beds_available_gh);$i++)
					{
						$bd = $this->Guesthouse_model->get_gesthouse_booking_list_bydate_avalability($get_beds_available_gh[$i]['gh_id'],$fdate,$tdate);
						
						?>
						<div class="col-md-3 main-box" >
			<div style="text-align:center;">
<?php
$rolid = $this->session->userdata("role_id");
if($rolid=='6'){
echo $get_beds_available_gh[$i]['campus'];
echo "<br/>";
}
$rmno = explode('_',$get_beds_available_gh[$i]['location']);
?>
			<h3 style="font-size: 19px;
    color: #ffffff;
    font-weight: 400;
    margin-top: 0px;
    padding: 10px;
    background-color: #1d89cf;
    border-top-left-radius: 7px;
    border-top-right-radius: 7px;"><?=$get_beds_available_gh[$i]['guesthouse_name']?></h3></div>
			
            <?php if($get_beds_available_gh[$i]['location']=='T'){ ?>
            <div style="padding:5px"><b>Floor:<?=$get_beds_available_gh[$i]['floor']?></b></div>
            <?php }else{ ?>
            <div style="margin:10px;padding:10px;">
			<div class="col-md-6" style="text-align:center;"><b>Room No:<?=$rmno[2]?></b></div>
            <div class="col-md-6" style="text-align:center;"><b>Floor:<?=$get_beds_available_gh[$i]['floor']?></b></div>
            </div>
			<?php } ?>
            <div style="padding:5px"><span style="color:#000;"><b>Available : </b></span><span style="color:black;" id="acnt_<?=$get_beds_available_gh[$i]['gh_id']?>"><b></b></span></div>
			<div class="table1" >
		<div class="row1" >
			<?php   $f = $get_beds_available_gh[$i]['bed_capacity'];
			//echo $get_beds_available_gh[$i]['doubel_bed'];
			$ck= explode(',',$get_beds_available_gh[$i]['doubel_bed']);
				//print_r($c[$get_beds_available_gh[$i]['gh_id']]);				
				for($k=1;$k<=$f;$k++){ 
				if(in_array($k, $ck)){
										$db = 'style=""';
									}else{
										$db='';
									}
									//echo $db;
		if(count($bd)>0){
		
			if(in_array($k,$bd)){
				$r= array_search($k,$bd);
				$r1= explode("_", $r);
				if(substr($r1[0],0,-1)=='CHECK-IN'){
					$bc = 'style="background-color:orange;"';
				}else{
					$bc = 'style="background-color:green;"';
				}
		//	}
			?>
<div data-target="#myModal" data-toggle="modal" data-id="<?=$r1[1]?>"  class="btn-block1 innerdiv"  <?=$bc?> <?=$db?>  ><?=$k?></div>
				<?php
						
				}else{
$a[$get_beds_available_gh[$i]['gh_id']][]=1;

					?>
			<div class="innerdiv" <?=$db?> ><?=$k?></div>
				<?php  } // } //}
		}else{ 
$a[$get_beds_available_gh[$i]['gh_id']][]=1;
			?>
		<div class="innerdiv" <?=$db?>  ><?=$k?></div>
		<?php }

			}
			?></div>
			</div>
			</div>
						<script>$('#acnt_<?=$get_beds_available_gh[$i]['gh_id']?>').text(<?php if(!empty($a[$get_beds_available_gh[$i]['gh_id']])) { echo array_sum($a[$get_beds_available_gh[$i]['gh_id']]); }else{ echo '0'; } ?>);</script>
					
						
						<?php 	//exit;
						$j++;
					}
					//print_r($act."_".$get_beds_available_gh[$i]['gh_id']);
					?> 
						<!--</table>-->	
					</div>
				</div>
				</br>
				<?php
				}else{
					?>
					<h4 style="color:red;padding-left:200px;">Guest House Have Not Found</h4>
					<?php
				}
				  ?>
				  <h4 style="color:red;padding-left:200px;" id="err_msg1"></h4>
				   </div>
                </div>
            </div>
			
            </div>    
<div id="myModal" class="modal" role="dialog"  >
						  <div class="modal-dialog" id="dispcon">

							<!-- Modal content-->
						

						  </div>
						</div>
						<script>
$('.btn-block1').on('click',function(){
            var id=$(this).data('id');
            //alert(id);
    $('.modal-body').html('loading');
       $.ajax({
        type: 'POST',
        url: '<?= base_url() ?>Guesthouse/get_booking_details',
        data:{id: id},
        success: function(data) {
          $('#dispcon').html(data);
        },
        error:function(err){
          alert("error"+JSON.stringify(err));
        }
    })
 });
</script>